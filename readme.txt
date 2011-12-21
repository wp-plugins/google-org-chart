=== Google Org Chart ===
Contributors: alekarsovski, ubcdev, ctlt-dev
Tags: org chart, org, chart, organizational, google, google org chart
Requires at least: 3.2.1
Tested up to: 3.2.1
Stable tag: 1.0.1

Shortcode plugin for simpler generation of org charts using Google's org chart API.

== Description ==

This plugin simplifies the generation of a Google org chart through the use of two shortcakes.

The shortcodes are [org_chart] and [org_chart_item].

The [org_chart_item] tag is used for the generation of each node in the chart and all [org_chart_item] tags should be enclosed between the opening [org_chart] and closing [/org_chart] tags.

[org_chart] has three attributes:


* width - set the width of the org chart drawing space (in pixels)
* height - set the height of the org chart drawing space (in pixels)
* collapsible - simply adding this word in the tag enables all parent nodes in the chart to be collapsible upon double-click

[org_chart_item] has four attributes:


* title - if the content attribute is not set, the title acts as a node ID and the node's content
* content - if the content attribute is set, it will be placed as the node's content while the title will simply act as the node ID
* parent - the ID of the parent node (if any); this is the parent node's title, not the content
* hover - what should be displayed when someone hovers over the node


**Example** org chart (result is shown in the screenshots):

<code>
[org_chart width='400' height='300' collapsible]
[org_chart_item title='Testing']
[org_chart_item title='TFCN' content='The First Child Node' parent='Testing']
[org_chart_item title='TSCN' content='The Second Child Node' parent='Testing']
[org_chart_item title='Link' content='<a href="http://www.zelda.com/gba/link_light_legend.html">A Link to the Past</a>' parent='TFCN' hover='Zelda']
[org_chart_item title='Grandchild' parent='TFCN']
[org_chart_item title='Black Sheep' parent='TSCN']
[org_chart_item title='SDE' content='XXXXXXX' parent='TSCN' hover='Seven Deadly Exes']
[/org_chart]
</code>


PLEASE NOTE: The Google org chart API generates the org chart through tables. Depending on the theme you are using you may experience some stylistic issue which can be fixed with some custom CSS. There are currently no plans to include any additional styling in the plugin out of the box.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the "google-org-chart" folder to the "/wp-content/plugins/" directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use the shortcode in any page or post where you wish your org chart to appear

== Frequently Asked Questions ==

= Why does my org chart look strange/have graphical issues? =

These issues are generally theme dependent and some custom CSS should fix any issues you may be experiencing.

== Screenshots ==

1. A small example org chart.

== Changelog ==

= 1.0.1 =
Code clean-up

== Upgrade Notice ==

= 1.0.1 =
Code clean-up