<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 后台管理地区白名单
 * 
 * @package Akalin
 * @author huhaku
 * @version 1.0.0
 * @link https://github.com/huhaku
 */
 include __DIR__ . '/Get_City.php';
 require __DIR__ . '/vendor/autoload.php';
class Akalin_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 插件版本号
     * @var string
     */
    const _VERSION = '1.0.0';
    
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('admin/common.php')->begin = array('Akalin_Plugin', 'check');
        Typecho_Plugin::factory('Widget_Login')->loginSucceed = array('Akalin_Plugin', 'check');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
		$get_city = new Get_City();
		$city=$get_city->City();
        /** 允许登陆后台的ip */
        $allow_city = new Typecho_Widget_Helper_Form_Element_Text('allow_city', NULL, NULL, _t('请输入允许登录的地区，如果允许多个请使用逗号隔开'),"例如你当前的地区是\"".$city['region_name'].$city['city_name']."\",你就可以填入\"".$city['region_name']."\"来允许一个省份或者填入\"".$city['city_name']."\"来允许一个城市。");
        $form->addInput($allow_city);
		
		 $activation = new Typecho_Widget_Helper_Form_Element_Radio('activation',
        array('0' => _t('未激活'),
            '1' => _t('激活')),
        '0', _t('默认为未激活状态，在顶部将会显示拦截信息，请在未激活状态下保存确认后再激活插件，以免进不了后台'));
		$form->addInput($activation);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 检测地区白名单
     * 
     * @access public
     * @return void
     */
    public static function check()
    {
		$config = json_decode(json_encode(unserialize(Helper::options()->plugin('Akalin'))));
            if(empty($config->allow_city)) {
				if (Typecho_Widget::widget('Widget_User')->hasLogin()){
                $options = Typecho_Widget::widget('Widget_Options');
                $config_url = trim($options->siteUrl,'/').'/'.trim(__TYPECHO_ADMIN_DIR__,'/').'/options-plugin.php?config=Akalin';
                echo '<span style="text-align: center;display: block;margin: auto;font-size: 1.5em;color:#1abc9c">您还没有设置地区白名单，<a href="'.$config_url.'">马上去设置</a></span>';
				}
            }else{
				$get_city_list = new Get_City();
				$city_list=$get_city_list->City();
                $allow_city = explode(',',str_replace('，',',',$config->allow_city));
				$prevent=true;
				if(in_array($city_list['region_name'], $allow_city)||in_array($city_list['city_name'], $allow_city)){
					$prevent=false;
					}
					$activation_code=1;//因为设置失误进不了后台请将1改为0(记得改回去
				if($config->activation&&$activation_code){
					if($prevent){
						Typecho_Cookie::delete('__typecho_uid');
                        Typecho_Cookie::delete('__typecho_authCode');
                        @session_destroy();
						$options = Typecho_Widget::widget('Widget_Options');
						echo file_get_contents($options->siteUrl);
                        exit;
					}
				}else{
					if(Typecho_Widget::widget('Widget_User')->hasLogin()){
						$options = Typecho_Widget::widget('Widget_Options');
							$config_url = trim($options->siteUrl,'/').'/'.trim(__TYPECHO_ADMIN_DIR__,'/').'/options-plugin.php?config=Akalin';
						if($prevent){
							echo '<span style="text-align: center;display: block;margin: auto;font-size: 1.5em;color:#FF0000">请注意，激活插件后你的当前所在地区会被被拦截，如有误，请到<a href="'.$config_url.'">设置页</a>更改</span>';
						}else{
							echo '<span style="text-align: center;display: block;margin: auto;font-size: 1.5em;color:#1abc9c">你的当前地区不会被拦截，如果无误请到设置页<a href="'.$config_url.'">激活</a>插件</span>';
						}
					}
				}
		}
	}
}