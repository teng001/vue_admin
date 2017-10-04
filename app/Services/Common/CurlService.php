<?php
namespace App\Services\Common;


/*
 *CURL
 */
class CurlService
{
	
	private $ch		= null;
	public $url	= null;
	private $option	= null;
	public $domain = null;
	/**
	 * 抓取页面构造方法
	 * @param type $url        页面url
	 * @return type            String
	 */
	public function __construct( $url = '' )
	{
		$url && $this->setUrl($url);
	}
	/**
	 * 创建 curl 会话
	 * @param type $url        页面url
	 * 初始化url时将域名替换成ip访问，防止curl无法解析域名的问题
	 */
	public function setUrl($url)
	{
		$tempu=parse_url($url);
		$this->domain=$tempu['host'];
		$ip = gethostbyname($this->domain);
		$this->url = str_replace($this->domain, $ip, $url);
	
		$this->ch	= curl_init( $this->url );
	}
	/**
	 * 单个配置 curl 参数
	 * @param type $option        参数名称
	 * @param type $value         参数值
	 * @return type               Object
	 */
	public function setOption( $option, $value )
	{
		curl_setopt($this->ch, $option, $value );
		return $this;
	}
	/**
	 * 批量配置 curl 参数
	 * @param type $options        array()参数的名称和值分别存在数组的下标名称和值中
	 * @return type               Object
	 */
	public function setOptions( $options )
	{
		if (!is_array( $options ))exit('The params for Gather::setOptions is not array.');
		foreach ( $options as $key => $val ) {
			$this->setOption( $key, $val );
		}
		return $this;
	}
	/**
	 * 获得抓取到的页面信息
	 * @return      Sting
	 */
	public function exec()
	{
		return curl_exec( $this->ch );
	}
	/**
	 * 关闭curl会话
	 */
	public function close()
	{
		curl_close( $this->ch );
	}
	/**
	 * 抓取指定url的页面信息
	 * 默认配置 1.启用时会将头文件的信息作为数据流输出。
	 *          2.将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
	 *          3.在发起连接前等待的时间（5秒），如果设置为0，则无限等待。
	 * @return Sting
	 */
	public function fetch($url = '', $timeout=5, $times = 1)
	{
		$url && $this->setUrl($url);
		$this->setOption( CURLOPT_HEADER, 0 );
		$this->setOption( CURLOPT_RETURNTRANSFER, 1 );
		$this->setOption(CURLOPT_HTTPHEADER, array('Host: '.$this->domain));//设置curl头，为域名，防止一个ip下有多个站点
		$this->setOption(CURLOPT_TIMEOUT, $timeout);
		$this->setOption(CURLOPT_SSL_VERIFYPEER, false);//在https的时候，放弃证书认证，否则无法取得数据
		$checkVersion = $this->checkVersion();
		$res = $this->exec();
		if(false === $res && true == $checkVersion ){
			if (curl_errno($this->ch) == CURLE_OPERATION_TIMEOUTED
					and $times != 3 ) {
						$times += 1;
						return $this->fetch($url, $times);
					}
		}
	
		return $res;
	}
	/**
	 * 抓取指定url的页面属性信息，包括页面大小、类型、加载时间、URL等信息
	 * @param type $url             页面url
	 * @return Array()
	 */
	public function getCurlInfo($url = ''){
		$this->fetch($url);
		$this->setOption( CURLOPT_CUSTOMREQUEST, 'HEAD');
		return curl_getinfo($this->ch);
	}
	/**
	 * 模拟POST提交后抓取指定url的页面信息
	 * @param type $postData        Array() post提交数据
	 * @param type $url             页面url
	 * @return Sting
	 */
	public  function postCurl($url = '', $postData = '', $timeout=5, $times = 1)
	{
		$url && $this->setUrl($url);
		if(is_array($postData)){
			$curlPost = '';
			foreach ($postData as $k => $v){
				$curlPost.=$k.'='.$v.'&';
			}
			$curlPost=  rtrim($curlPost, '&');
			$this->setOption( CURLOPT_HEADER, 0 );
			$this->setOption( CURLOPT_RETURNTRANSFER, 1 );
			$this->setOption( CURLOPT_TIMEOUT, $timeout);
			$this->setOption( CURLOPT_POST, 1);
			$this->setOption( CURLOPT_POSTFIELDS, $curlPost);
			$this->setOption(CURLOPT_HTTPHEADER, array('Host: '.$this->domain));//设置curl头，为域名，防止一个ip下有多个站点
			$this->setOption(CURLOPT_SSL_VERIFYPEER, false); //在https的时候，放弃证书认证，否则无法取得数据
			$checkVersion = $this->checkVersion();
		}
		$res = $this->exec();
		if(false === $res && true == $checkVersion ){
			if (curl_errno($this->ch) == CURLE_OPERATION_TIMEOUTED
					&& $times != 3 ) {
						$times += 1;
						return $this->postCurl($url, $postData, $times);
					}
		}
		return $res;
	}
	/**
	 * 版本号对比
	 * 462850 //因为php的CURLOPT_CONNECTTIMEOUT_MS需要 curl_version 7.16.2,
	 * 这个值就是这个版本的数字版本号，还需要注意的是, php版本要大于5.2.3
	 * @return boolean false 版本过低，true 版本合适
	 */
	public function checkVersion(){
		$curl_version = curl_version();
		if ($curl_version['version_number'] < 462850) {
			return false;
		}else{
			//开启毫秒级等待
			$this->setOption(CURLOPT_NOSIGNAL, 1);
			$this->setOption(CURLOPT_CONNECTTIMEOUT_MS, 3000);//等待100毫秒
		}
		return true;
	}
	
	
}