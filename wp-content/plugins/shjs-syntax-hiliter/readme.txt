=== Plugin Name ===
Contributors: zach
Donate link: http://www.codezach.com
Tags: syntax,hiliter,highlighter,hilighter,plugin
Requires at least: 2.7.1
Tested up to: 2.8
Stable tag: trunk

Syntax hilight 30 languages, 2 dozen themes to choose from. Uses the SHJS syntax hilighter. 

== Description ==

Syntax hilight 30 languages, 2 dozen themes to choose from. Fast, can easily hilight 1000 lines of code (the Google Syntax Hilighter based plugins die around 75-100 lines). 

2 ways to include code in your posts - use as documented on SHJS or use the [SyntaxHilite:...] syntax described in the installation/usage section to link to a raw text file. 

Uses [SHJS](http://shjs.sourceforge.net/) for syntax hilighting, simple hand-rolled JavaScript for line numbering.

== Installation ==

1. Upload the SHJSSyntaxHiliter directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Select a theme from the Settings->SHJS Syntax Hiliter options page.

There are 2 ways to include your code:

**Technique 1** 
Inside &lt;pre name="code" class="sh_java"&gt;&lt;/pre&gt; just as you would normally use SHJS.

**Technique 2**

1. Copy your code into a file on your server.

2. In your posts pass the webroot relative path and language like this: 

[SyntaxHilite:/path/relative/to/site/root/myfile.java,java]

The supported languages, etc. are detailed on the Settings->SHJS Syntax Hiliter page.

Additional usage instructions can be found on [codezach](http://www.codezach.com/?p=328)

== Frequently Asked Questions ==

= Can this thing hilight my language? =

There are 30 languages available, check the languages on [SHJS](http://shjs.sourceforge.net/).

= How can I tell what the themes look like without applying them and refreshing? =

Check out the theme previewer on [SHJS](http://shjs.sourceforge.net/). It would be nice to have theme preview integrated with
the options, but I'm out of time for now...

== Screenshots ==
[See CodeZach for Demo](http://www.codezach.com/?p=328)