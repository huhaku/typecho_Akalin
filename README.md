# Typecho 后台IP白名单插件 Akalin

## 插件简介

激活插件后在白名单地区的用户才能访问后台,从而拦截掉绝大部分未在常用登录地的IP对后台的非法请求。<br>
插件名字是阿卡林（Akalin），想不到合适的名字，随便起的。<br>

## 安装方法

1. 到https://github.com/huhaku/typecho_Akalin项目中下载最新版本的文件；<br>
2. 将下载的压缩包进行解压，重命名为`Akalin`，并上传至`Typecho`插件目录中；<br>
3. 后台激活插件，设置常用登录地并保存。<br>
4. 保存后插件尚未激活，你可以在顶部提示中验证插件的设置是否正确。<br>
5. 验证无误后选择激活插件，提示消失，插件开始工作。<br>

已测试可用typecho版本 1.1 (17.10.30)<br>

## 注意

1. 如果你的设置出错或者不在常用登录地导致打不开后台，请将Plugin.php的第100行$activation_code的1改为0，让插件的拦截失效。<br>
2. 因为IP地址的分配经常变动，因为运营商IP分配问题或IP分配变动导致无法准确判断你的登录地点的时候，你可以到https://www.ipip.net/product/client.html下载最新版本的ipdb数据文件来覆盖掉目录下的ipiptest.ipdb文件<br> (长宽或鹏博士这类出口满天乱飞的用户可以洗洗睡了。<br> 

## 感谢

本插件使用了以下作者的开源项目<br> 

[ipipdotnet] https://github.com/ipipdotnet/ipdb-php <br> 
[fuzqing] https://github.com/fuzqing/AllowIp-Typecho-Plugin/releases <br> 