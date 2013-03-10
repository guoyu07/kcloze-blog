=== WP Microblogs ===
Contributors: raychow
Donate link: http://beamnote.com/
Tags: microblog, widgets, sidebar, twitter, sina, tencent, fanfou
Requires at least: 2.9.2
Tested up to: 3.3.1
Stable tag: 0.4.0
License: GPLv2 or later

WP Microblogs displays the latest microblog in WordPress.

== Description ==

WP Microblogs displays the latest microblog in WordPress, support for Twitter, Sina Weibo, Tencent Weibo, fanfou
 and other microblogs.

**Chinese version ONLY temporarily**.

WP Microblogs 可以在 WordPress 中显示最新微博推文，目前支持新浪微博、腾讯微博、Twitter、网易微博、搜狐微博、饭否、豆瓣
除 XAuth 之外的所有可用的认证方式。对于更加开放的微博（例如 Twitter、饭否），只输入用户名即可展示推文。

在目前的版本中，至少已经包含下列功能：

*   提供一种直接展示最新微博推文的小工具；
*   智能过滤重复推文，为推文中提到的 URL 添加链接；
*   使用 `wm_tweet()`、`wm_tweets()`(函数) 或 `[wm_tweet]`、`[wm_tweets]`(短代码) 在指定位置展示最新的一条或数条推文；
*   使用 `wm_get_tweet_arr()` 或 `wm_get_tweets_arr()` 获得微博原始数据；
*   较完善的缓存机制，减少资源占用；
*   提供数个过滤器(filter)与动作(action)自定义展示方式。

请访问[插件主页](http://beamnote.com/2011/wp-microblogs.html "WP Microblogs 插件主页")以获取更多信息。

== Installation ==

= English =
1. Upload `wp-microblogs` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add microblog accounts in 'WP Microblogs' panel
1. Add microblog widgets

= 中文 =
2. 上传 `wp-microblogs` 文件夹到 `/wp-content/plugins/` 目录
2. 在插件面板中激活插件
2. 在 'WP Microblogs' 面板中添加微博帐号
2. 在小工具面板中添加"微博"小工具

== Changelog ==

= 0.1.0 =
*  0.1.0 Released.

= 0.1.4 =
*  增加: 调用接口：头像。
*  修正: 腾讯微博未登录时获取 OAuth 授权时的错误；

= 0.2.0 =
*  增加: 小工具自定义功能，目前可以自定义尺寸、颜色与头像显示方式；
*  修正: 代码优化。

= 0.2.5 =
*  增加: 小工具滚动样式选择；
*  增加: JS 输出微博功能（测试中）；
*  修正: 小工具输出的错误；
*  修正: IE6 兼容性。

= 0.2.8 =
*  增加: 豆瓣广播支持；
*  增加: 短代码支持: `[wm_tweet]` 与 `[wm_tweets]`，在文章与页面中直接插入即可显示最新推文；
*  修正: JS 输出的问题。

= 0.2.9 =
*  增加: 缓存更新时间预告；
*  增加: 卸载选项；
*  修正: 支持到 WordPress 3.1；
*  修正: 缓存更新逻辑优化；
*  修正: 后台部分选项无法修改的问题；
*  修正: WordPress 2.9.2 后台无法添加帐号的问题。

= 0.3.0 =
*  增加: 小工具微博时间、来源开关；
*  修正: 潜在的 OAuth 类冲突问题（可以与其它微博插件共存）。

= 0.3.1 =
*  增加: 用于帮助寻找插件故障原因简单的测试程序；
*  修正: 潜在的无法显示微博的问题。

= 0.3.3 =
*  修正: 新浪微博 ID 记录为科学记数法的问题；
*  修正: 适应新浪微博平台升级。

= 0.4.0 =
*  增加: 自动更新用户信息；
*  增加: 一键关注；
*  增加: 图片显示开关；
*  增加: Cron Job 故障检查功能；
*  修正: 改进的小工具面板；
*  修正: 微博缓存逻辑优化；
*  修正: 微博更新逻辑优化；
*  修正: 腾讯微博转播信息疏漏的问题；
*  移除: 停止对**嘀咕、做啥、人间**微博的支持；