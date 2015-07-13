<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




































if ( !class_exists('S3') ) {


class S3 {
		const ACL_PRIVATE = 'private';
	const ACL_PUBLIC_READ = 'public-read';
	const ACL_PUBLIC_READ_WRITE = 'public-read-write';
	const ACL_AUTHENTICATED_READ = 'authenticated-read';

	const STORAGE_CLASS_STANDARD = 'STANDARD';
	const STORAGE_CLASS_RRS = 'REDUCED_REDUNDANCY';

	private static $__accessKey = null; 	private static $__secretKey = null; 	private static $__sslKey = null;

	public static $endpoint = 's3.amazonaws.com';
	public static $proxy = null;

	public static $useSSL = false;
	public static $useSSLValidation = true;
	public static $useExceptions = false;

		public static $sslKey = null;
	public static $sslCert = null;
	public static $sslCACert = null;

	private static $__signingKeyPairId = null; 	private static $__signingKeyResource = false; 

	







	public function __construct($accessKey=null,$secretKey=null,$useSSL=false,$endpoint='s3.amazonaws.com')
	{
		if ($accessKey !== null && $secretKey !== null)
			self::setAuth($accessKey, $secretKey);

		self::$useSSL = $useSSL;
		self::$endpoint = $endpoint;
	}


	





	public function setEndpoint($host)
	{
		self::$endpoint = $host;
	}

	






	public static function setAuth($accessKey,$secretKey)
	{
		self::$__accessKey = $accessKey;
		self::$__secretKey = $secretKey;
	}


	




	public static function hasAuth() {
		return (self::$__accessKey !== null && self::$__secretKey !== null);
	}


	






	public static function setSSL($enabled,$validate=true)
	{
		self::$useSSL = $enabled;
		self::$useSSLValidation = $validate;
	}


	







	public static function setSSLAuth($sslCert=null,$sslKey=null,$sslCACert=null)
	{
		self::$sslCert = $sslCert;
		self::$sslKey = $sslKey;
		self::$sslCACert = $sslCACert;
	}


	








	public static function setProxy($host,$user=null,$pass=null,$type=CURLPROXY_SOCKS5)
	{
		self::$proxy = array('host' => $host, 'type' => $type, 'user' => null, 'pass' => 'null');
	}


	





	public static function setExceptions($enabled=true)
	{
		self::$useExceptions = $enabled;
	}


	







	public static function setSigningKey($keyPairId,$signingKey,$isFile=true)
	{
		self::$__signingKeyPairId = $keyPairId;
		if ((self::$__signingKeyResource = openssl_pkey_get_private($isFile ?
		file_get_contents($signingKey) : $signingKey)) !== false) return true;
		self::__triggerError('S3::setSigningKey(): Unable to open load private key: '.$signingKey, __FILE__, __LINE__);
		return false;
	}


	




	public static function freeSigningKey()
	{
		if (self::$__signingKeyResource !== false)
			openssl_free_key(self::$__signingKeyResource);
	}


	









	private static function __triggerError($message,$file,$line,$code=0)
	{
		if (self::$useExceptions)
			throw new S3Exception($message, $file, $line, $code);
		else {
			$messageC = WMessage::get();
			$messageC->adminE( $message );
			WMessage::log( $message, 'Amazon-S3-error' );
		}
	}


	





	public static function listBuckets($detailed=false)
	{
		$rest = new S3Request('GET', '', '', self::$endpoint);
		$rest = $rest->getResponse();
		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::listBuckets(): [%s] %s", $rest->error['code'],
			$rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		$results = array();
		if (!isset($rest->body->Buckets)) return $results;

		if ($detailed)
		{
			if (isset($rest->body->Owner, $rest->body->Owner->ID, $rest->body->Owner->DisplayName))
			$results['owner'] = array(
				'id' => (string)$rest->body->Owner->ID, 'name' => (string)$rest->body->Owner->ID
			);
			$results['buckets'] = array();
			foreach($rest->body->Buckets->Bucket as $b)
				$results['buckets'][] = array(
					'name' => (string)$b->Name, 'time' => strtotime((string)$b->CreationDate)
				);
		} else
			foreach($rest->body->Buckets->Bucket as $b) $results[] = (string)$b->Name;

		return $results;
	}


	












	public static function getBucket($bucket,$prefix=null,$marker=null,$maxKeys=null,$delimiter=null,$returnCommonPrefixes=false)
	{
		$rest = new S3Request('GET', $bucket, '', self::$endpoint);
		if ($maxKeys == 0) $maxKeys = null;
		if ($prefix !== null && $prefix !== '') $rest->setParameter('prefix', $prefix);
		if ($marker !== null && $marker !== '') $rest->setParameter('marker', $marker);
		if ($maxKeys !== null && $maxKeys !== '') $rest->setParameter('max-keys', $maxKeys);
		if ($delimiter !== null && $delimiter !== '') $rest->setParameter('delimiter', $delimiter);
		$response = $rest->getResponse();
		if ($response->error === false && $response->code !== 200)
			$response->error = array('code' => $response->code, 'message' => 'Unexpected HTTP status');
		if ($response->error !== false)
		{
			self::__triggerError(sprintf("S3::getBucket(): [%s] %s",
			$response->error['code'], $response->error['message']), __FILE__, __LINE__);
			return false;
		}

		$results = array();

		$nextMarker = null;
		if (isset($response->body, $response->body->Contents))
		foreach($response->body->Contents as $c)
		{
			$results[(string)$c->Key] = array(
				'name' => (string)$c->Key,
				'time' => strtotime((string)$c->LastModified),
				'size' => (int)$c->Size,
				'hash' => substr((string)$c->ETag, 1, -1)
			);
			$nextMarker = (string)$c->Key;
		}

		if ($returnCommonPrefixes && isset($response->body, $response->body->CommonPrefixes))
			foreach($response->body->CommonPrefixes as $c)
				$results[(string)$c->Prefix] = array('prefix' => (string)$c->Prefix);

		if (isset($response->body, $response->body->IsTruncated) &&
		(string)$response->body->IsTruncated == 'false') return $results;

		if (isset($response->body, $response->body->NextMarker))
			$nextMarker = (string)$response->body->NextMarker;

				if ($maxKeys == null && $nextMarker !== null && (string)$response->body->IsTruncated == 'true')
		do
		{
			$rest = new S3Request('GET', $bucket, '', self::$endpoint);
			if ($prefix !== null && $prefix !== '') $rest->setParameter('prefix', $prefix);
			$rest->setParameter('marker', $nextMarker);
			if ($delimiter !== null && $delimiter !== '') $rest->setParameter('delimiter', $delimiter);

			if (($response = $rest->getResponse()) == false || $response->code !== 200) break;

			if (isset($response->body, $response->body->Contents))
			foreach($response->body->Contents as $c)
			{
				$results[(string)$c->Key] = array(
					'name' => (string)$c->Key,
					'time' => strtotime((string)$c->LastModified),
					'size' => (int)$c->Size,
					'hash' => substr((string)$c->ETag, 1, -1)
				);
				$nextMarker = (string)$c->Key;
			}

			if ($returnCommonPrefixes && isset($response->body, $response->body->CommonPrefixes))
				foreach($response->body->CommonPrefixes as $c)
					$results[(string)$c->Prefix] = array('prefix' => (string)$c->Prefix);

			if (isset($response->body, $response->body->NextMarker))
				$nextMarker = (string)$response->body->NextMarker;

		} while ($response !== false && (string)$response->body->IsTruncated == 'true');

		return $results;
	}


	







	public static function putBucket($bucket,$acl=self::ACL_PRIVATE,$location=false)
	{
		$rest = new S3Request('PUT', $bucket, '', self::$endpoint);
		$rest->setAmzHeader('x-amz-acl', $acl);

		if ($location !== false)
		{
			if ( ! class_exists( 'DOMDocument' ) ) {
			$this->userN('1433250437OEYO');
			return false;
		}			$dom = new DOMDocument;
			$createBucketConfiguration = $dom->createElement('CreateBucketConfiguration');
			$locationConstraint = $dom->createElement('LocationConstraint', $location);
			$createBucketConfiguration->appendChild($locationConstraint);
			$dom->appendChild($createBucketConfiguration);
			$rest->data = $dom->saveXML();
			$rest->size = strlen($rest->data);
			$rest->setHeader('Content-Type', 'application/xml');
		}
		$rest = $rest->getResponse();

		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::putBucket({$bucket}, {$acl}, {$location}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		return true;
	}


	





	public static function deleteBucket($bucket)
	{
		$rest = new S3Request('DELETE', $bucket, '', self::$endpoint);
		$rest = $rest->getResponse();
		if ($rest->error === false && $rest->code !== 204)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::deleteBucket({$bucket}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		return true;
	}


	






	public static function inputFile($file,$md5sum=true)
	{
		if (!file_exists($file) || !is_file($file) || !is_readable($file))
		{
			self::__triggerError('S3::inputFile(): Unable to open input file: '.$file, __FILE__, __LINE__);
			return false;
		}
		return array('file' => $file, 'size' => filesize($file), 'md5sum' => $md5sum !== false ?
		(is_string($md5sum) ? $md5sum : base64_encode(md5_file($file, true))) : '');
	}


	







	public static function inputResource(&$resource,$bufferSize,$md5sum='')
	{
		if (!is_resource($resource) || $bufferSize < 0)
		{
			self::__triggerError('S3::inputResource(): Invalid resource or buffer size', __FILE__, __LINE__);
			return false;
		}
		$input = array('size' => $bufferSize, 'md5sum' => $md5sum);
		$input['fp'] =& $resource;
		return $input;
	}


	











	public static function putObject($input,$bucket,$uri,$acl=self::ACL_PRIVATE,$metaHeaders=array(),$requestHeaders=array(),$storageClass=self::STORAGE_CLASS_STANDARD)
	{
		if ($input === false) return false;
		$rest = new S3Request('PUT', $bucket, $uri, self::$endpoint);

		if (!is_array($input)) $input = array(
			'data' => $input, 'size' => strlen($input),
			'md5sum' => base64_encode(md5($input, true))
		);

				if (isset($input['fp']))
			$rest->fp =& $input['fp'];
		elseif (isset($input['file']))
			$rest->fp = @fopen($input['file'], 'rb');
		elseif (isset($input['data']))
			$rest->data = $input['data'];

				if (isset($input['size']) && $input['size'] >= 0)
			$rest->size = $input['size'];
		else {
			if (isset($input['file']))
				$rest->size = filesize($input['file']);
			elseif (isset($input['data']))
				$rest->size = strlen($input['data']);
		}

				if (is_array($requestHeaders))
			foreach($requestHeaders as $h => $v) $rest->setHeader($h, $v);
		elseif (is_string($requestHeaders)) 			$input['type'] = $requestHeaders;

				if (!isset($input['type']))
		{
			if (isset($requestHeaders['Content-Type']))
				$input['type'] =& $requestHeaders['Content-Type'];
			elseif (isset($input['file']))
				$input['type'] = self::__getMimeType($input['file']);
			else
				$input['type'] = 'application/octet-stream';
		}

		if ($storageClass !== self::STORAGE_CLASS_STANDARD) 			$rest->setAmzHeader('x-amz-storage-class', $storageClass);

				if ($rest->size >= 0 && ($rest->fp !== false || $rest->data !== false))
		{
			$rest->setHeader('Content-Type', $input['type']);
			if (isset($input['md5sum'])) $rest->setHeader('Content-MD5', $input['md5sum']);

			$rest->setAmzHeader('x-amz-acl', $acl);
			foreach($metaHeaders as $h => $v) $rest->setAmzHeader('x-amz-meta-'.$h, $v);
			$rest->getResponse();
		} else
			$rest->response->error = array('code' => 0, 'message' => 'Missing input parameters');

		if ($rest->response->error === false && $rest->response->code !== 200)
			$rest->response->error = array('code' => $rest->response->code, 'message' => 'Unexpected HTTP status');
		if ($rest->response->error !== false)
		{
			self::__triggerError(sprintf("S3::putObject(): [%s] %s",
			$rest->response->error['code'], $rest->response->error['message']), __FILE__, __LINE__);
			return false;
		}
		return true;
	}


	










	public static function putObjectFile($file,$bucket,$uri,$acl=self::ACL_PRIVATE,$metaHeaders=array(),$contentType=null)
	{
		return self::putObject(self::inputFile($file), $bucket, $uri, $acl, $metaHeaders, $contentType);
	}


	










	public static function putObjectString($string,$bucket,$uri,$acl=self::ACL_PRIVATE,$metaHeaders=array(),$contentType='text/plain')
	{
		return self::putObject($string, $bucket, $uri, $acl, $metaHeaders, $contentType);
	}


	







	public static function getObject($bucket,$uri,$saveTo=false)
	{
		$rest = new S3Request('GET', $bucket, $uri, self::$endpoint);
		if ($saveTo !== false)
		{
			if (is_resource($saveTo))
				$rest->fp =& $saveTo;
			else
				if (($rest->fp = @fopen($saveTo, 'wb')) !== false)
					$rest->file = realpath($saveTo);
				else
					$rest->response->error = array('code' => 0, 'message' => 'Unable to open save file for writing: '.$saveTo);
		}
		if ($rest->response->error === false) $rest->getResponse();

		if ($rest->response->error === false && $rest->response->code !== 200)
			$rest->response->error = array('code' => $rest->response->code, 'message' => 'Unexpected HTTP status');
		if ($rest->response->error !== false)
		{
			self::__triggerError(sprintf("S3::getObject({$bucket}, {$uri}): [%s] %s",
			$rest->response->error['code'], $rest->response->error['message']), __FILE__, __LINE__);
			return false;
		}
		return $rest->response;
	}


	







	public static function getObjectInfo($bucket,$uri,$returnInfo=true)
	{
		$rest = new S3Request('HEAD', $bucket, $uri, self::$endpoint);
		$rest = $rest->getResponse();
		if ($rest->error === false && ($rest->code !== 200 && $rest->code !== 404))
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::getObjectInfo({$bucket}, {$uri}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		return $rest->code == 200 ? $returnInfo ? $rest->headers : true : false;
	}


	












	public static function copyObject($srcBucket,$srcUri,$bucket,$uri,$acl=self::ACL_PRIVATE,$metaHeaders=array(),$requestHeaders=array(),$storageClass=self::STORAGE_CLASS_STANDARD)
	{
		$rest = new S3Request('PUT', $bucket, $uri, self::$endpoint);
		$rest->setHeader('Content-Length', 0);
		foreach($requestHeaders as $h => $v) $rest->setHeader($h, $v);
		foreach($metaHeaders as $h => $v) $rest->setAmzHeader('x-amz-meta-'.$h, $v);
		if ($storageClass !== self::STORAGE_CLASS_STANDARD) 			$rest->setAmzHeader('x-amz-storage-class', $storageClass);
		$rest->setAmzHeader('x-amz-acl', $acl);
		$rest->setAmzHeader('x-amz-copy-source', sprintf('/%s/%s', $srcBucket, rawurlencode($srcUri)));
		if (sizeof($requestHeaders) > 0 || sizeof($metaHeaders) > 0)
			$rest->setAmzHeader('x-amz-metadata-directive', 'REPLACE');

		$rest = $rest->getResponse();
		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::copyObject({$srcBucket}, {$srcUri}, {$bucket}, {$uri}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		return isset($rest->body->LastModified, $rest->body->ETag) ? array(
			'time' => strtotime((string)$rest->body->LastModified),
			'hash' => substr((string)$rest->body->ETag, 1, -1)
		) : false;
	}


	







	public static function setBucketLogging($bucket,$targetBucket,$targetPrefix=null)
	{
				if ($targetBucket !== null && ($acp = self::getAccessControlPolicy($targetBucket, '')) !== false)
		{
						$aclWriteSet = false;
			$aclReadSet = false;
			foreach($acp['acl'] as $acl)
			if ($acl['type'] == 'Group' && $acl['uri'] == 'http://acs.amazonaws.com/groups/s3/LogDelivery')
			{
				if ($acl['permission'] == 'WRITE') $aclWriteSet = true;
				elseif ($acl['permission'] == 'READ_ACP') $aclReadSet = true;
			}
			if (!$aclWriteSet) $acp['acl'][] = array(
				'type' => 'Group', 'uri' => 'http://acs.amazonaws.com/groups/s3/LogDelivery', 'permission' => 'WRITE'
			);
			if (!$aclReadSet) $acp['acl'][] = array(
				'type' => 'Group', 'uri' => 'http://acs.amazonaws.com/groups/s3/LogDelivery', 'permission' => 'READ_ACP'
			);
			if (!$aclReadSet || !$aclWriteSet) self::setAccessControlPolicy($targetBucket, '', $acp);
		}

		if ( ! class_exists( 'DOMDocument' ) ) {
			$this->userN('1433250437OEYO');
			return false;
		}		$dom = new DOMDocument;
		$bucketLoggingStatus = $dom->createElement('BucketLoggingStatus');
		$bucketLoggingStatus->setAttribute('xmlns', 'http://s3.amazonaws.com/doc/2006-03-01/');
		if ($targetBucket !== null)
		{
			if ($targetPrefix == null) $targetPrefix = $bucket . '-';
			$loggingEnabled = $dom->createElement('LoggingEnabled');
			$loggingEnabled->appendChild($dom->createElement('TargetBucket', $targetBucket));
			$loggingEnabled->appendChild($dom->createElement('TargetPrefix', $targetPrefix));
						$bucketLoggingStatus->appendChild($loggingEnabled);
		}
		$dom->appendChild($bucketLoggingStatus);

		$rest = new S3Request('PUT', $bucket, '', self::$endpoint);
		$rest->setParameter('logging', null);
		$rest->data = $dom->saveXML();
		$rest->size = strlen($rest->data);
		$rest->setHeader('Content-Type', 'application/xml');
		$rest = $rest->getResponse();
		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::setBucketLogging({$bucket}, {$targetBucket}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		return true;
	}


	








	public static function getBucketLogging($bucket)
	{
		$rest = new S3Request('GET', $bucket, '', self::$endpoint);
		$rest->setParameter('logging', null);
		$rest = $rest->getResponse();
		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::getBucketLogging({$bucket}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		if (!isset($rest->body->LoggingEnabled)) return false; 		return array(
			'targetBucket' => (string)$rest->body->LoggingEnabled->TargetBucket,
			'targetPrefix' => (string)$rest->body->LoggingEnabled->TargetPrefix,
		);
	}


	





	public static function disableBucketLogging($bucket)
	{
		return self::setBucketLogging($bucket, null);
	}


	





	public static function getBucketLocation($bucket)
	{
		$rest = new S3Request('GET', $bucket, '', self::$endpoint);
		$rest->setParameter('location', null);
		$rest = $rest->getResponse();
		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::getBucketLocation({$bucket}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		return (isset($rest->body[0]) && (string)$rest->body[0] !== '') ? (string)$rest->body[0] : 'US';
	}


	







	public static function setAccessControlPolicy($bucket,$uri='',$acp=array())
	{
		if ( ! class_exists( 'DOMDocument' ) ) {
			$this->userN('1433250437OEYO');
			return false;
		}		$dom = new DOMDocument;
		$dom->formatOutput = true;
		$accessControlPolicy = $dom->createElement('AccessControlPolicy');
		$accessControlList = $dom->createElement('AccessControlList');

				$owner = $dom->createElement('Owner');
		$owner->appendChild($dom->createElement('ID', $acp['owner']['id']));
		$owner->appendChild($dom->createElement('DisplayName', $acp['owner']['name']));
		$accessControlPolicy->appendChild($owner);

		foreach($acp['acl'] as $g)
		{
			$grant = $dom->createElement('Grant');
			$grantee = $dom->createElement('Grantee');
			$grantee->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
			if (isset($g['id']))
			{ 				$grantee->setAttribute('xsi:type', 'CanonicalUser');
				$grantee->appendChild($dom->createElement('ID', $g['id']));
			}
			elseif (isset($g['email']))
			{ 				$grantee->setAttribute('xsi:type', 'AmazonCustomerByEmail');
				$grantee->appendChild($dom->createElement('EmailAddress', $g['email']));
			}
			elseif ($g['type'] == 'Group')
			{ 				$grantee->setAttribute('xsi:type', 'Group');
				$grantee->appendChild($dom->createElement('URI', $g['uri']));
			}
			$grant->appendChild($grantee);
			$grant->appendChild($dom->createElement('Permission', $g['permission']));
			$accessControlList->appendChild($grant);
		}

		$accessControlPolicy->appendChild($accessControlList);
		$dom->appendChild($accessControlPolicy);

		$rest = new S3Request('PUT', $bucket, $uri, self::$endpoint);
		$rest->setParameter('acl', null);
		$rest->data = $dom->saveXML();
		$rest->size = strlen($rest->data);
		$rest->setHeader('Content-Type', 'application/xml');
		$rest = $rest->getResponse();
		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::setAccessControlPolicy({$bucket}, {$uri}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		return true;
	}


	






	public static function getAccessControlPolicy($bucket,$uri='')
	{
		$rest = new S3Request('GET', $bucket, $uri, self::$endpoint);
		$rest->setParameter('acl', null);
		$rest = $rest->getResponse();
		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::getAccessControlPolicy({$bucket}, {$uri}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}

		$acp = array();
		if (isset($rest->body->Owner, $rest->body->Owner->ID, $rest->body->Owner->DisplayName))
			$acp['owner'] = array(
				'id' => (string)$rest->body->Owner->ID, 'name' => (string)$rest->body->Owner->DisplayName
			);

		if (isset($rest->body->AccessControlList))
		{
			$acp['acl'] = array();
			foreach($rest->body->AccessControlList->Grant as $grant)
			{
				foreach($grant->Grantee as $grantee)
				{
					if (isset($grantee->ID, $grantee->DisplayName)) 						$acp['acl'][] = array(
							'type' => 'CanonicalUser',
							'id' => (string)$grantee->ID,
							'name' => (string)$grantee->DisplayName,
							'permission' => (string)$grant->Permission
						);
					elseif (isset($grantee->EmailAddress)) 						$acp['acl'][] = array(
							'type' => 'AmazonCustomerByEmail',
							'email' => (string)$grantee->EmailAddress,
							'permission' => (string)$grant->Permission
						);
					elseif (isset($grantee->URI)) 						$acp['acl'][] = array(
							'type' => 'Group',
							'uri' => (string)$grantee->URI,
							'permission' => (string)$grant->Permission
						);
					else continue;
				}
			}
		}
		return $acp;
	}


	






	public static function deleteObject($bucket,$uri)
	{
		$rest = new S3Request('DELETE', $bucket, $uri, self::$endpoint);
		$rest = $rest->getResponse();
		if ($rest->error === false && $rest->code !== 204)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::deleteObject(): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		return true;
	}


	









	public static function getAuthenticatedURL($bucket,$uri,$lifetime,$hostBucket=false,$https=false)
	{
		$expires = time() + $lifetime;
		$uri = str_replace(array('%2F', '%2B'), array('/', '+'), rawurlencode($uri));
		return sprintf(($https ? 'https' : 'http').'://%s/%s?AWSAccessKeyId=%s&Expires=%u&Signature=%s',
				$hostBucket ? $bucket : 's3.amazonaws.com/'.$bucket, $uri, self::$__accessKey, $expires,
		urlencode(self::__getHash("GET\n\n\n{$expires}\n/{$bucket}/{$uri}")));
	}


	





	public static function getSignedPolicyURL($policy)
	{
		$data = json_encode($policy);
		$signature = '';
		if (!openssl_sign($data, $signature, self::$__signingKeyResource)) return false;

		$encoded = str_replace(array('+', '='), array('-', '_', '~'), base64_encode($data));
		$signature = str_replace(array('+', '='), array('-', '_', '~'), base64_encode($signature));

		$url = $policy['Statement'][0]['Resource'] . '?';
		foreach(array('Policy' => $encoded, 'Signature' => $signature, 'Key-Pair-Id' => self::$__signingKeyPairId) as $k => $v)
			$url .= $k.'='.str_replace('%2F', '/', rawurlencode($v)).'&';
		return substr($url, 0, -1);
	}


	






	public static function getSignedCannedURL($url,$lifetime)
	{
		return self::getSignedPolicyURL(array(
			'Statement' => array(
				array('Resource' => $url, 'Condition' => array(
					'DateLessThan' => array('AWS:EpochTime' => time() + $lifetime)
				))
			)
		));
	}


	













	public static function getHttpUploadPostParams($bucket,$uriPrefix='',$acl=self::ACL_PRIVATE,$lifetime=3600,$maxFileSize=5242880,$successRedirect="201",$amzHeaders=array(),$headers=array(),$flashVars=false)
	{
				$policy = new stdClass;
		$policy->expiration = gmdate('Y-m-d\TH:i:s\Z', (time() + $lifetime));
		$policy->conditions = array();
		$obj = new stdClass; $obj->bucket = $bucket; array_push($policy->conditions, $obj);
		$obj = new stdClass; $obj->acl = $acl; array_push($policy->conditions, $obj);

		$obj = new stdClass; 		if (is_numeric($successRedirect) && in_array((int)$successRedirect, array(200, 201)))
			$obj->success_action_status = (string)$successRedirect;
		else 			$obj->success_action_redirect = $successRedirect;
		array_push($policy->conditions, $obj);

		if ($acl !== self::ACL_PUBLIC_READ)
			array_push($policy->conditions, array('eq', '$acl', $acl));

		array_push($policy->conditions, array('starts-with', '$key', $uriPrefix));
		if ($flashVars) array_push($policy->conditions, array('starts-with', '$Filename', ''));
		foreach(array_keys($headers) as $headerKey)
			array_push($policy->conditions, array('starts-with', '$'.$headerKey, ''));
		foreach($amzHeaders as $headerKey => $headerVal)
		{
			$obj = new stdClass;
			$obj->{$headerKey} = (string)$headerVal;
			array_push($policy->conditions, $obj);
		}
		array_push($policy->conditions, array('content-length-range', 0, $maxFileSize));
		$policy = base64_encode(str_replace('\/', '/', json_encode($policy)));

				$params = new stdClass;
		$params->AWSAccessKeyId = self::$__accessKey;
		$params->key = $uriPrefix.'${filename}';
		$params->acl = $acl;
		$params->policy = $policy; unset($policy);
		$params->signature = self::__getHash($params->policy);
		if (is_numeric($successRedirect) && in_array((int)$successRedirect, array(200, 201)))
			$params->success_action_status = (string)$successRedirect;
		else
			$params->success_action_redirect = $successRedirect;
		foreach($headers as $headerKey => $headerVal) $params->{$headerKey} = (string)$headerVal;
		foreach($amzHeaders as $headerKey => $headerVal) $params->{$headerKey} = (string)$headerVal;
		return $params;
	}


	











	public static function createDistribution($bucket,$enabled=true,$cnames=array(),$comment=null,$defaultRootObject=null,$originAccessIdentity=null,$trustedSigners=array())
	{
		if (!extension_loaded('openssl'))
		{
			self::__triggerError(sprintf("S3::createDistribution({$bucket}, ".(int)$enabled.", [], '$comment'): %s",
			"CloudFront functionality requires SSL"), __FILE__, __LINE__);
			return false;
		}
		$useSSL = self::$useSSL;

		self::$useSSL = true; 		$rest = new S3Request('POST', '', '2010-11-01/distribution', 'cloudfront.amazonaws.com');
		$rest->data = self::__getCloudFrontDistributionConfigXML(
			$bucket.'.s3.amazonaws.com',
			$enabled,
			(string)$comment,
			(string)microtime(true),
			$cnames,
			$defaultRootObject,
			$originAccessIdentity,
			$trustedSigners
		);

		$rest->size = strlen($rest->data);
		$rest->setHeader('Content-Type', 'application/xml');
		$rest = self::__getCloudFrontResponse($rest);

		self::$useSSL = $useSSL;

		if ($rest->error === false && $rest->code !== 201)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::createDistribution({$bucket}, ".(int)$enabled.", [], '$comment'): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		} elseif ($rest->body instanceof SimpleXMLElement)
			return self::__parseCloudFrontDistributionConfig($rest->body);
		return false;
	}


	





	public static function getDistribution($distributionId)
	{
		if (!extension_loaded('openssl'))
		{
			self::__triggerError(sprintf("S3::getDistribution($distributionId): %s",
			"CloudFront functionality requires SSL"), __FILE__, __LINE__);
			return false;
		}
		$useSSL = self::$useSSL;

		self::$useSSL = true; 		$rest = new S3Request('GET', '', '2010-11-01/distribution/'.$distributionId, 'cloudfront.amazonaws.com');
		$rest = self::__getCloudFrontResponse($rest);

		self::$useSSL = $useSSL;

		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::getDistribution($distributionId): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		elseif ($rest->body instanceof SimpleXMLElement)
		{
			$dist = self::__parseCloudFrontDistributionConfig($rest->body);
			$dist['hash'] = $rest->headers['hash'];
			$dist['id'] = $distributionId;
			return $dist;
		}
		return false;
	}


	





	public static function updateDistribution($dist)
	{
		if (!extension_loaded('openssl'))
		{
			self::__triggerError(sprintf("S3::updateDistribution({$dist['id']}): %s",
			"CloudFront functionality requires SSL"), __FILE__, __LINE__);
			return false;
		}

		$useSSL = self::$useSSL;

		self::$useSSL = true; 		$rest = new S3Request('PUT', '', '2010-11-01/distribution/'.$dist['id'].'/config', 'cloudfront.amazonaws.com');
		$rest->data = self::__getCloudFrontDistributionConfigXML(
			$dist['origin'],
			$dist['enabled'],
			$dist['comment'],
			$dist['callerReference'],
			$dist['cnames'],
			$dist['defaultRootObject'],
			$dist['originAccessIdentity'],
			$dist['trustedSigners']
		);

		$rest->size = strlen($rest->data);
		$rest->setHeader('If-Match', $dist['hash']);
		$rest = self::__getCloudFrontResponse($rest);

		self::$useSSL = $useSSL;

		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::updateDistribution({$dist['id']}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		} else {
			$dist = self::__parseCloudFrontDistributionConfig($rest->body);
			$dist['hash'] = $rest->headers['hash'];
			return $dist;
		}
		return false;
	}


	





	public static function deleteDistribution($dist)
	{
		if (!extension_loaded('openssl'))
		{
			self::__triggerError(sprintf("S3::deleteDistribution({$dist['id']}): %s",
			"CloudFront functionality requires SSL"), __FILE__, __LINE__);
			return false;
		}

		$useSSL = self::$useSSL;

		self::$useSSL = true; 		$rest = new S3Request('DELETE', '', '2008-06-30/distribution/'.$dist['id'], 'cloudfront.amazonaws.com');
		$rest->setHeader('If-Match', $dist['hash']);
		$rest = self::__getCloudFrontResponse($rest);

		self::$useSSL = $useSSL;

		if ($rest->error === false && $rest->code !== 204)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::deleteDistribution({$dist['id']}): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		return true;
	}


	




	public static function listDistributions()
	{
		if (!extension_loaded('openssl'))
		{
			self::__triggerError(sprintf("S3::listDistributions(): [%s] %s",
			"CloudFront functionality requires SSL"), __FILE__, __LINE__);
			return false;
		}

		$useSSL = self::$useSSL;
		self::$useSSL = true; 		$rest = new S3Request('GET', '', '2010-11-01/distribution', 'cloudfront.amazonaws.com');
		$rest = self::__getCloudFrontResponse($rest);
		self::$useSSL = $useSSL;

		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			self::__triggerError(sprintf("S3::listDistributions(): [%s] %s",
			$rest->error['code'], $rest->error['message']), __FILE__, __LINE__);
			return false;
		}
		elseif ($rest->body instanceof SimpleXMLElement && isset($rest->body->DistributionSummary))
		{
			$list = array();
			if (isset($rest->body->Marker, $rest->body->MaxItems, $rest->body->IsTruncated))
			{
															}
			foreach($rest->body->DistributionSummary as $summary)
				$list[(string)$summary->Id] = self::__parseCloudFrontDistributionConfig($summary);

			return $list;
		}
		return array();
	}

	




	public static function listOriginAccessIdentities()
	{
		if (!extension_loaded('openssl'))
		{
			self::__triggerError(sprintf("S3::listOriginAccessIdentities(): [%s] %s",
			"CloudFront functionality requires SSL"), __FILE__, __LINE__);
			return false;
		}

		self::$useSSL = true; 		$rest = new S3Request('GET', '', '2010-11-01/origin-access-identity/cloudfront', 'cloudfront.amazonaws.com');
		$rest = self::__getCloudFrontResponse($rest);
		$useSSL = self::$useSSL;

		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			trigger_error(sprintf("S3::listOriginAccessIdentities(): [%s] %s",
			$rest->error['code'], $rest->error['message']), E_USER_WARNING);
			return false;
		}

		if (isset($rest->body->CloudFrontOriginAccessIdentitySummary))
		{
			$identities = array();
			foreach($rest->body->CloudFrontOriginAccessIdentitySummary as $identity)
				if (isset($identity->S3CanonicalUserId))
					$identities[(string)$identity->Id] = array('id' => (string)$identity->Id, 's3CanonicalUserId' => (string)$identity->S3CanonicalUserId);
			return $identities;
		}
		return false;
	}


	








	public static function invalidateDistribution($distributionId,$paths)
	{
		if (!extension_loaded('openssl'))
		{
			self::__triggerError(sprintf("S3::invalidateDistribution(): [%s] %s",
			"CloudFront functionality requires SSL"), __FILE__, __LINE__);
			return false;
		}

		$useSSL = self::$useSSL;
		self::$useSSL = true; 		$rest = new S3Request('POST', '', '2010-08-01/distribution/'.$distributionId.'/invalidation', 'cloudfront.amazonaws.com');
		$rest->data = self::__getCloudFrontInvalidationBatchXML($paths, (string)microtime(true));
		$rest->size = strlen($rest->data);
		$rest = self::__getCloudFrontResponse($rest);
		self::$useSSL = $useSSL;

		if ($rest->error === false && $rest->code !== 201)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			trigger_error(sprintf("S3::invalidate('{$distributionId}',{$paths}): [%s] %s",
			$rest->error['code'], $rest->error['message']), E_USER_WARNING);
			return false;
		}
		return true;
	}


	






	private static function __getCloudFrontInvalidationBatchXML($paths,$callerReference='0') {

		if ( ! class_exists( 'DOMDocument' ) ) {
			$this->userN('1433250437OEYO');
			return false;
		}		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->formatOutput = true;
		$invalidationBatch = $dom->createElement('InvalidationBatch');
		foreach($paths as $path)
			$invalidationBatch->appendChild($dom->createElement('Path', $path));

		$invalidationBatch->appendChild($dom->createElement('CallerReference', $callerReference));
		$dom->appendChild($invalidationBatch);
		return $dom->saveXML();
	}


	















	public static function getDistributionInvalidationList($distributionId)
	{
		if (!extension_loaded('openssl'))
		{
			self::__triggerError(sprintf("S3::getDistributionInvalidationList(): [%s] %s",
			"CloudFront functionality requires SSL"), __FILE__, __LINE__);
			return false;
		}

		$useSSL = self::$useSSL;
		self::$useSSL = true; 		$rest = new S3Request('GET', '', '2010-11-01/distribution/'.$distributionId.'/invalidation', 'cloudfront.amazonaws.com');
		$rest = self::__getCloudFrontResponse($rest);
		self::$useSSL = $useSSL;

		if ($rest->error === false && $rest->code !== 200)
			$rest->error = array('code' => $rest->code, 'message' => 'Unexpected HTTP status');
		if ($rest->error !== false)
		{
			trigger_error(sprintf("S3::getDistributionInvalidationList('{$distributionId}'): [%s]",
			$rest->error['code'], $rest->error['message']), E_USER_WARNING);
			return false;
		}
		elseif ($rest->body instanceof SimpleXMLElement && isset($rest->body->InvalidationSummary))
		{
			$list = array();
			foreach($rest->body->InvalidationSummary as $summary)
				$list[(string)$summary->Id] = (string)$summary->Status;

			return $list;
		}
		return array();
	}


	















	private static function __getCloudFrontDistributionConfigXML($bucket,$enabled,$comment,$callerReference='0',$cnames=array(),$defaultRootObject=null,$originAccessIdentity=null,$trustedSigners=array())
	{
		if ( ! class_exists( 'DOMDocument' ) ) {
			$this->userN('1433250437OEYO');
			return false;
		}		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->formatOutput = true;
		$distributionConfig = $dom->createElement('DistributionConfig');
		$distributionConfig->setAttribute('xmlns', 'http://cloudfront.amazonaws.com/doc/2010-11-01/');

		$origin = $dom->createElement('S3Origin');
		$origin->appendChild($dom->createElement('DNSName', $bucket));
		if ($originAccessIdentity !== null) $origin->appendChild($dom->createElement('OriginAccessIdentity', $originAccessIdentity));
		$distributionConfig->appendChild($origin);

		if ($defaultRootObject !== null) $distributionConfig->appendChild($dom->createElement('DefaultRootObject', $defaultRootObject));

		$distributionConfig->appendChild($dom->createElement('CallerReference', $callerReference));
		foreach($cnames as $cname)
			$distributionConfig->appendChild($dom->createElement('CNAME', $cname));
		if ($comment !== '') $distributionConfig->appendChild($dom->createElement('Comment', $comment));
		$distributionConfig->appendChild($dom->createElement('Enabled', $enabled ? 'true' : 'false'));

		$trusted = $dom->createElement('TrustedSigners');
		foreach($trustedSigners as $id => $type)
			$trusted->appendChild($id !== '' ? $dom->createElement($type, $id) : $dom->createElement($type));
		$distributionConfig->appendChild($trusted);

		$dom->appendChild($distributionConfig);
				return $dom->saveXML();
	}


	








	private static function __parseCloudFrontDistributionConfig(&$node)
	{
		if (isset($node->DistributionConfig))
			return self::__parseCloudFrontDistributionConfig($node->DistributionConfig);

		$dist = array();
		if (isset($node->Id, $node->Status, $node->LastModifiedTime, $node->DomainName))
		{
			$dist['id'] = (string)$node->Id;
			$dist['status'] = (string)$node->Status;
			$dist['time'] = strtotime((string)$node->LastModifiedTime);
			$dist['domain'] = (string)$node->DomainName;
		}

		if (isset($node->CallerReference))
			$dist['callerReference'] = (string)$node->CallerReference;

		if (isset($node->Enabled))
			$dist['enabled'] = (string)$node->Enabled == 'true' ? true : false;

		if (isset($node->S3Origin))
		{
			if (isset($node->S3Origin->DNSName))
				$dist['origin'] = (string)$node->S3Origin->DNSName;

			$dist['originAccessIdentity'] = isset($node->S3Origin->OriginAccessIdentity) ?
			(string)$node->S3Origin->OriginAccessIdentity : null;
		}

		$dist['defaultRootObject'] = isset($node->DefaultRootObject) ? (string)$node->DefaultRootObject : null;

		$dist['cnames'] = array();
		if (isset($node->CNAME))
			foreach($node->CNAME as $cname)
				$dist['cnames'][(string)$cname] = (string)$cname;

		$dist['trustedSigners'] = array();
		if (isset($node->TrustedSigners))
			foreach($node->TrustedSigners as $signer)
			{
				if (isset($signer->Self))
					$dist['trustedSigners'][''] = 'Self';
				elseif (isset($signer->KeyPairId))
					$dist['trustedSigners'][(string)$signer->KeyPairId] = 'KeyPairId';
				elseif (isset($signer->AwsAccountNumber))
					$dist['trustedSigners'][(string)$signer->AwsAccountNumber] = 'AwsAccountNumber';
			}

		$dist['comment'] = isset($node->Comment) ? (string)$node->Comment : null;
		return $dist;
	}


	






	private static function __getCloudFrontResponse(&$rest)
	{
		$rest->getResponse();
		if ($rest->response->error === false && isset($rest->response->body) &&
		is_string($rest->response->body) && substr($rest->response->body, 0, 5) == '<?xml')
		{
			$rest->response->body = simplexml_load_string($rest->response->body);
						if (isset($rest->response->body->Error, $rest->response->body->Error->Code,
			$rest->response->body->Error->Message))
			{
				$rest->response->error = array(
					'code' => (string)$rest->response->body->Error->Code,
					'message' => (string)$rest->response->body->Error->Message
				);
				unset($rest->response->body);
			}
		}
		return $rest->response;
	}


	






	public static function __getMimeType(&$file)
	{
		$type = false;
						if (extension_loaded('fileinfo') && isset($_ENV['MAGIC']) &&
		($finfo = finfo_open(FILEINFO_MIME, $_ENV['MAGIC'])) !== false)
		{
			if (($type = finfo_file($finfo, $file)) !== false)
			{
								$type = explode(' ', str_replace('; charset=', ';charset=', $type));
				$type = array_pop($type);
				$type = explode(';', $type);
				$type = trim(array_shift($type));
			}
			finfo_close($finfo);

				} elseif (function_exists('mime_content_type'))
			$type = trim(mime_content_type($file));

		if ($type !== false && strlen($type) > 0) return $type;

				static $exts = array(
			'jpg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png',
			'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'ico' => 'image/x-icon',
			'swf' => 'application/x-shockwave-flash', 'pdf' => 'application/pdf',
			'zip' => 'application/zip', 'gz' => 'application/x-gzip',
			'tar' => 'application/x-tar', 'bz' => 'application/x-bzip',
			'bz2' => 'application/x-bzip2', 'txt' => 'text/plain',
			'asc' => 'text/plain', 'htm' => 'text/html', 'html' => 'text/html',
			'css' => 'text/css', 'js' => 'text/javascript',
			'xml' => 'text/xml', 'xsl' => 'application/xsl+xml',
			'ogg' => 'application/ogg', 'mp3' => 'audio/mpeg', 'wav' => 'audio/x-wav',
			'avi' => 'video/x-msvideo', 'mpg' => 'video/mpeg', 'mpeg' => 'video/mpeg',
			'mov' => 'video/quicktime', 'flv' => 'video/x-flv', 'php' => 'text/x-php'
		);
		$ext = strtolower(pathInfo($file, PATHINFO_EXTENSION));
		return isset($exts[$ext]) ? $exts[$ext] : 'application/octet-stream';
	}


	






	public static function __getSignature($string)
	{
		return 'AWS '.self::$__accessKey.':'.self::__getHash($string);
	}


	








	private static function __getHash($string)
	{
		return base64_encode(extension_loaded('hash') ?
		hash_hmac('sha1', $string, self::$__secretKey, true) : pack('H*', sha1(
		(str_pad(self::$__secretKey, 64, chr(0x00)) ^ (str_repeat(chr(0x5c), 64))) .
		pack('H*', sha1((str_pad(self::$__secretKey, 64, chr(0x00)) ^
		(str_repeat(chr(0x36), 64))) . $string)))));
	}

}}

if (!class_exists('S3Request') ) {

final class S3Request{
	private $endpoint, $verb, $bucket, $uri, $resource = '', $parameters = array(),
	$amzHeaders = array(), $headers = array(
		'Host' => '', 'Date' => '', 'Content-MD5' => '', 'Content-Type' => ''
	);
	public $fp = false, $size = 0, $data = false, $response;


	







	function __construct($verb,$bucket='',$uri='',$endpoint='s3.amazonaws.com')
	{
		$this->endpoint = $endpoint;
		$this->verb = $verb;
		$this->bucket = $bucket;
		$this->uri = $uri !== '' ? '/'.str_replace('%2F', '/', rawurlencode($uri)) : '/';

								
		if ($this->bucket !== '')
		{
			if ($this->__dnsBucketName($this->bucket))
			{
				$this->headers['Host'] = $this->bucket.'.'.$this->endpoint;
				$this->resource = '/'.$this->bucket.$this->uri;
			} else {
				$this->headers['Host'] = $this->endpoint;
				$this->uri = $this->uri;
				if ($this->bucket !== '') $this->uri = '/'.$this->bucket.$this->uri;
				$this->bucket = '';
				$this->resource = $this->uri;
			}
		} else {
			$this->headers['Host'] = $this->endpoint;
			$this->resource = $this->uri;
		}


		$this->headers['Date'] = gmdate('D, d M Y H:i:s T');
		$this->response = new STDClass;
		$this->response->error = false;
	}


	






	public function setParameter($key,$value)
	{
		$this->parameters[$key] = $value;
	}


	






	public function setHeader($key,$value)
	{
		$this->headers[$key] = $value;
	}


	






	public function setAmzHeader($key,$value)
	{
		$this->amzHeaders[$key] = $value;
	}


	




	public function getResponse()
	{
		$query = '';
		if (sizeof($this->parameters) > 0)
		{
			$query = substr($this->uri, -1) !== '?' ? '?' : '&';
			foreach($this->parameters as $var => $value)
				if ($value == null || $value == '') $query .= $var.'&';
				else $query .= $var.'='.rawurlencode($value).'&';
			$query = substr($query, 0, -1);
			$this->uri .= $query;

			if (array_key_exists('acl', $this->parameters) ||
			array_key_exists('location', $this->parameters) ||
			array_key_exists('torrent', $this->parameters) ||
			array_key_exists('website', $this->parameters) ||
			array_key_exists('logging', $this->parameters))
				$this->resource .= $query;
		}
		$url = (S3::$useSSL ? 'https://' : 'http://') . ($this->headers['Host'] !== '' ? $this->headers['Host'] : $this->endpoint) . $this->uri;

		
				$curl = curl_init();
		curl_setopt($curl, CURLOPT_USERAGENT, 'S3/php');

		if ( S3::$useSSL ) {
						curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, S3::$useSSLValidation ? 2 : 0 );
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, S3::$useSSLValidation ? 1 : 0 );

			if (S3::$sslKey !== null) curl_setopt($curl, CURLOPT_SSLKEY, S3::$sslKey);
			if (S3::$sslCert !== null) curl_setopt($curl, CURLOPT_SSLCERT, S3::$sslCert);
			if (S3::$sslCACert !== null) curl_setopt($curl, CURLOPT_CAINFO, S3::$sslCACert);
		}

		curl_setopt($curl, CURLOPT_URL, $url);

		if (S3::$proxy != null && isset(S3::$proxy['host']))
		{
			curl_setopt($curl, CURLOPT_PROXY, S3::$proxy['host']);
			curl_setopt($curl, CURLOPT_PROXYTYPE, S3::$proxy['type']);
			if (isset(S3::$proxy['user'], S3::$proxy['pass']) && S3::$proxy['user'] != null && S3::$proxy['pass'] != null)
				curl_setopt($curl, CURLOPT_PROXYUSERPWD, sprintf('%s:%s', S3::$proxy['user'], S3::$proxy['pass']));
		}

				$headers = array(); $amz = array();
		foreach($this->amzHeaders as $header => $value)
			if (strlen($value) > 0) $headers[] = $header.': '.$value;
		foreach($this->headers as $header => $value)
			if (strlen($value) > 0) $headers[] = $header.': '.$value;

				foreach($this->amzHeaders as $header => $value)
			if (strlen($value) > 0) $amz[] = strtolower($header).':'.$value;

				if (sizeof($amz) > 0)
		{
						usort($amz, array(&$this, '__sortMetaHeadersCmp'));
			$amz = "\n".implode("\n", $amz);
		} else $amz = '';

		if (S3::hasAuth()) {
						if ($this->headers['Host'] == 'cloudfront.amazonaws.com')
				$headers[] = 'Authorization: ' . S3::__getSignature($this->headers['Date']);
			else
			{
				$headers[] = 'Authorization: ' . S3::__getSignature(
					$this->verb."\n".
					$this->headers['Content-MD5']."\n".
					$this->headers['Content-Type']."\n".
					$this->headers['Date'].$amz."\n".
					$this->resource
				);
			}
        }
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $curl, CURLOPT_HEADER, false);
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, false);
		curl_setopt( $curl, CURLOPT_WRITEFUNCTION, array(&$this, '__responseWriteCallback'));
		curl_setopt( $curl, CURLOPT_HEADERFUNCTION, array(&$this, '__responseHeaderCallback'));
		$safeMode = ini_get( 'safe_mode' );
    	$openBasedir = ini_get( 'open_basedir' );
    	if ( empty($safeMode) && empty($openBasedir) ) {
    		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
    	}

				switch ( $this->verb ) {
			case 'GET': break;
			case 'PUT': case 'POST': 				if ($this->fp !== false)
				{
					curl_setopt($curl, CURLOPT_PUT, true);
					curl_setopt($curl, CURLOPT_INFILE, $this->fp);
					if ($this->size >= 0)
						curl_setopt($curl, CURLOPT_INFILESIZE, $this->size);
				}
				elseif ($this->data !== false)
				{
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->verb);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data);
				}
				else
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->verb);
			break;
			case 'HEAD':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'HEAD');
				curl_setopt($curl, CURLOPT_NOBODY, true);
			break;
			case 'DELETE':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
			break;
			default: break;
		}

				if (curl_exec($curl))
			$this->response->code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		else
			$this->response->error = array(
				'code' => curl_errno($curl),
				'message' => curl_error($curl),
				'resource' => $this->resource
			);

		@curl_close($curl);

				if ($this->response->error === false && isset($this->response->headers['type']) &&
		$this->response->headers['type'] == 'application/xml' && isset($this->response->body))
		{
			$this->response->body = simplexml_load_string($this->response->body);

						if (!in_array($this->response->code, array(200, 204, 206)) &&
			isset($this->response->body->Code, $this->response->body->Message))
			{
				$this->response->error = array(
					'code' => (string)$this->response->body->Code,
					'message' => (string)$this->response->body->Message
				);
				if (isset($this->response->body->Resource))
					$this->response->error['resource'] = (string)$this->response->body->Resource;
				unset($this->response->body);
			}
		}

				if ($this->fp !== false && is_resource($this->fp)) fclose($this->fp);

		return $this->response;
	}

	







	private function __sortMetaHeadersCmp($a,$b)
	{
		$lenA = strpos($a, ':');
		$lenB = strpos($b, ':');
		$minLen = min($lenA, $lenB);
		$ncmp = strncmp($a, $b, $minLen);
		if ($lenA == $lenB) return $ncmp;
		if (0 == $ncmp) return $lenA < $lenB ? -1 : 1;
		return $ncmp;
	}

	






	private function __responseWriteCallback(&$curl,&$data)
	{
		if (in_array($this->response->code, array(200, 206)) && $this->fp !== false)
			return fwrite($this->fp, $data);
		else
			$this->response->body .= $data;
		return strlen($data);
	}


	





	private function __dnsBucketName($bucket)
	{
		if (strlen($bucket) > 63 || !preg_match("/[^a-z0-9\.-]/", $bucket)) return false;
		if (strstr($bucket, '-.') !== false) return false;
		if (strstr($bucket, '..') !== false) return false;
		if (!preg_match("/^[0-9a-z]/", $bucket)) return false;
		if (!preg_match("/[0-9a-z]$/", $bucket)) return false;
		return true;
	}


	






	private function __responseHeaderCallback(&$curl,&$data)
	{
		if (($strlen = strlen($data)) <= 2) return $strlen;
		if (substr($data, 0, 4) == 'HTTP')
			$this->response->code = (int)substr($data, 9, 3);
		else
		{
			$data = trim($data);
			if (strpos($data, ': ') === false) return $strlen;
			list($header, $value) = explode(': ', $data, 2);
			if ($header == 'Last-Modified')
				$this->response->headers['time'] = strtotime($value);
			elseif ($header == 'Content-Length')
				$this->response->headers['size'] = (int)$value;
			elseif ($header == 'Content-Type')
				$this->response->headers['type'] = $value;
			elseif ($header == 'ETag')
				$this->response->headers['hash'] = $value{0} == '"' ? substr($value, 1, -1) : $value;
			elseif (preg_match('/^x-amz-meta-.*$/', $header))
				$this->response->headers[$header] = $value;
		}
		return $strlen;
	}

}}

if (!class_exists('S3Exception') ) {

class S3Exception extends Exception {
	function __construct($message,$file,$line,$code=0)
	{
		parent::__construct($message, $code);
		$this->file = $file;
		$this->line = $line;
	}
}
}