---
type: document
title: Write code in your posts (Classic Editor)
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/write-code-in-your-posts-classic-editor/"
tags:
timestamp: "2026-06-16T19:29:07+00:00"
wordpress:
  id: 2381
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:07"
  date_gmt: "2026-06-16 19:29:07"
  modified: "2026-06-16 19:29:07"
  modified_gmt: "2026-06-16 19:29:07"
  slug: write-code-in-your-posts-classic-editor
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/write-code-in-your-posts-classic-editor/"
  comment_count: 0
  terms:
    category:
      - publishing
      - support-guides
---

Whether you write [plugins](/support/article/plugins/) or hacks for WordPress, or you want to add bits and pieces of code about your own WordPress site or other [programming](https://en.wikipedia.org/wiki/Code_(disambiguation)#Computing) code like HTML, CSS, PHP, or JavaScript, putting code in your [post](/support/article/writing-posts/) that *looks* like code, but doesn’t *behave* like code, is a frequent challenge for bloggers.

By default, the way a piece of code written or pasted to WordPress [post editor](/support/article/writing-posts/) is interpreted depends on whether you use visual or HTML post editor. Visual editor will consider the code to be an ordinary text, converting (encoding) the &lt; and &gt; characters into their &lt; and &gt; [character entity](/support/article/glossary#character-entity) equivalents, so that the code is not interpreted by a web browser. Quotes are converted too, but remember that by default, WordPress also applies [auto-correction](#quotes-auto-correction) so that the text is quoted properly according to your language specifics. HTML editor does not convert any of these characters, so be aware that HTML and CSS markup you use in your code examples will be recognized by a web browser and you may end up with a funky looking text and a messed up layout.

Note that this behavior may differ with respect to the WordPress version, post editor and other plugins used. In some older versions of WordPress, unrecognized uses of the &lt; and &gt; characters were converted into the &amp;lt; and &amp;gt; character entities, and when an [HTML tag](https://en.wikipedia.org/wiki/HTML_element) was found within the post, the tag was left as it was, allowing for its interpretation in a web browser.

## Code Within Paragraphs

The HTML tag which will turn text into a `monospaced` font. They are &lt;code&gt; and &lt;tt&gt;. The latter is rarely used today, replaced by the more useful and semantically correct &lt;code&gt;, which distinguishes text that is computer code from natural language.

```
This is an example which mentions code within a paragraph,namely the functions wp_title(), wp_content() and wp_footer(), which are very useful in WordPress.
```

This is great for making a piece of non-HTML text look like code, but what about HTML tags that you want to showcase?

```
In the header.php template file,look for the <div class="header">section to change the <h1> heading.
```

Using the `` tag doesn’t tell WordPress to encode HTML markup within the tag or strip it from the post. WordPress thinks that you are using this markup for formatting, leaving it untouched. A web browser then sees a `` tag followed by a `<div>` tag and so it responds by creating a new container in your web page.

To avoid this behavior, use [character entities or extended characters](https://codex.wordpress.org/Fun_Character_Entities) to represent the left and right arrow characters in a way that is not recognized as the beginning and end of an HTML tag by a web browser, like this:

```
In the header.php template file,look for the &lt;div class="header"&gt;section to change the &lt;h1&gt; heading.
```

## URLs Within Paragraphs

By default, WordPress will turn any phrase that begins with *http:* into a link. If you are giving an example of how to link to a specific post within a WordPress site, instead of using the link with *`http://example.com/index.php?p=453`* and having it turn into a link, you can use extended characters for the slashes, so WordPress won’t “see” the link:

```
...link to a specific WordPress post using http:& amp;#47;& amp;#47;example.com& amp;#47;index.php?p=453in your post....
```

Note: Take off Space between ‘&amp;’ and ‘amp’.

## List of Related Character Entities

Here is a list of some HTML character entities related to the topic of this article:

```
(less than) = &lt; or &#060;
(greater than) = &gt; or &#062;
/ = &#047;
] = &#093;
[ = &#091;
" = &quot; or &#034;
' = &#039;
“ = &ldquo; or &#8220;
” = &rdquo; or &#8220;
‘ = &lsquo; or &#8216;
’ = &rsquo; or &#8217;
(ampersand) = &amp; or &#038;
```

There is a list of resources below which will help you turn HTML tags into character entities automatically, so you don’t have to memorize these character codes.

## Using the &lt;pre&gt; tag

To set your code aside so that it looks like a box of code which may be copied and pasted within other code or template file, you can use the &lt;pre&gt; HTML tag.

The &lt;pre&gt; tag instructs the browser to use a monospaced font, but to *exactly reproduce* whatever is inside of the &lt;pre&gt;tags. Every space, line break, every bit of code is exactly reproduced.

```
<h3>Section Three Title</h3><p>This is the start of a <a title="article on relationships" href="goodtalk.php">good relationship</a> between you and me....
```

Using the &lt;pre&gt; tag isn’t very “pretty” but it does the job. Examples of how to style it can be found in the next section. Still, it showcases the code *exactly*.

By *exactly*, we mean EXACTLY. If you have a long line of code, it will run off the page because there are no *instructions*which tell the code to wrap. It won’t. Here is an example:

```
<h3>Section Three Title</h3><p>This is the start of a <a title="article on relationships"href="goodtalk.php">good relationship</a> between you and I and I think you should read it because it isimportant that we have these little <a title="article on communication"href="communication.php">conversations</a> once in a while to let each other know how we feel....
```

Not pretty, is it. To avoid this screen run-off, put in line breaks. Unfortunately, deciding where to put those line breaks in when you are showcasing code that will be copied makes it a difficult decision.

If you are familiar with programming language, you will know when a line break won’t mess up a line of code, so choose there. If you are unfamiliar with where to put line breaks, experiment. Put the code in, make the line breaks, and then test the code. If it works, then use the line break there. If not, change the line break position.

If you have long lines of code, consider showcasing only excerpts and providing a link to the full code placed on your site in a text or PHP file, or using one of the many online pastebins which are available for temporarily showcasing code.

## Troubleshooting Codes

Writing code within a WordPress post can be a challenge, maybe forcing you to override the WordPress default styles and to use filters which “fix” what we write. If you are having trouble with writing code within your WordPress post, this section might help.

### Quotes Auto-correction

A frequent problem when using codes within your post is the quotes auto-correction feature of WordPress, mostly known from word processing software. By default, when serving a web page, WordPress converts the **“**straight**“** quotes into the opening and closing “curly” quotation marks according to your WordPress [installation language](/support/article/installing-wordpress-in-your-language/) set in the *wp-config.php* file. Note that the auto-correction (also called smart quotes) feature is applied regardless of whether you have written the quotes in visual or HTML post editor.

In HTML post editor, you can avoid this problem by wrapping the quotes with the &lt;code&gt;, &lt;tt&gt; or &lt;pre&gt; tags. Other solution is replacing quotes with their respective character entities, e.g. using:

```
<p class=& #34;red& #34;>    // Take off space between & and #
```

instead of:

```
<p class="red">
```

Note that in some older versions of WordPress, if you edited a page again after publishing it, the HTML editor replaced all these entities with their literal equivalents. For example, if you carefully used &amp;#34 for your quotes, they would have come back as “, and if saved, the auto-correction feature would have an effect on them.

## Resources

- [Fun Character Entities](<https://codex.wordpress.org/Fun Character Entities>)

### Frequent Code User

If you consistently use a lot of formulas, functions, and programming code in your posts, consider using a plugin or PHP tool to make the entire process easier. If you tend to post a LOT of code blocks, consider pasting the code in a Paste Bin and linking to it on your site.

- [FigureRender](https://chris-lamb.co.uk/projects/figurerender) – LaTeX rendering plugin
- [9 Syntax Highlighter Plugins and Services for Embedding Code Snippets in WordPress](http://www.narga.net/syntax-highlighter-wordpress-plugins-code-snippets/) – Following are list of best WordPress plugins or 3rd-party services to highlight code snippets within your blog that I have personally tried in 2013.
- [Coffee2code’s Preserve Code Formatting WordPress Plugin](http://www.coffee2code.com/archives/2005/03/29/plugin-preserve-code-formatting/)
- [QuickCode WordPress Plugin](http://blog.netnerds.net/quickcode/) – Hides/unhides formatted blocks of code.
- [Using ASCIIMath](http://www1.chapman.edu/~jipsen/mathml/asciimath.html)
- [LaTex – A document preparation system](http://www.latex-project.org/)
- [Using LaTeX in WordPress](http://sixthform.info/steve/wordpress/index.php?cat=2)
- [Display mathematical equations within your posts](https://wordpress.org/plugins/wpmathpub/)
- [How to Build Dean Lee’s Plugin](http://www.embeddedcomponents.com/blogs/2007/05/how-to-build-dean-lees-syntax-highlighter-from-latest-components/) – A plugin for GeSHi – Generic Syntax Highlighter
- [Visual Code Editor Plugin](http://www.webveteran.com/blog/index.php/visual-code-editor/) – Modifies WordPress’s behavior so that code format is preserved when using the visual editor. It will work with any syntax highlighter that accepts encoded/escaped syntax.
- [SyntaxHighlighter Evolved](http://www.viper007bond.com/wordpress-plugins/syntaxhighlighter/) – allows you to easily post syntax-highlighted code to your site without having to escape the code.

### Paste Tools

- [Pastebin.com](http://www.pastebin.com/)
- [GitHub:Gist](https://gist.github.com/)
