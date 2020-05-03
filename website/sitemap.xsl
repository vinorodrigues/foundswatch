<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
  xmlns:html="http://www.w3.org/TR/REC-html40"
  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
  xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
	<xsl:template match="/">
		<html xmlns="http://www.w3.org/1999/xhtml" class="no-js" lang="en">
		<head>
			<meta charset="utf-8" />
			<meta http-equiv="x-ua-compatible" content="ie=edge" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<title>Foundswatch: XML Sitemap</title>
			<link rel="shortcut icon" href="favicon.ico" />
			<link rel="icon" type="image/gif" href="favicon.gif" />
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.6.3/css/foundation.min.css" />
			<style>
				thead tr { border-bottom: 1px solid rgba(0,0,0,0.50); }
				tfoot {	background: inherit; }
				tfoot tr { border-top: 1px solid rgba(0,0,0,0.50); }
				tfoot td { font-weight: 400; }
				.favicon { width: 0.8em !important; height: 0.8em !important; margin-bottom: 0.2em; margin-right: 0.33em; }
			</style>
		</head>
		<body>
		<div class="grid-container">
			<h1><img src="favicon.gif" width="100" height="100" class="favicon" />XML Sitemap</h1>
			<p>
				<span class="lead subheader">This is an XML Sitemap, meant for consumption by search engines.</span><br />
				You can find more information about XML sitemaps on <a href="http://sitemaps.org/" target="_blank" rel="noopener noreferrer">sitemaps.org</a>.
			</p>
			<xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &gt; 0">
				<table>
					<thead><tr>
						<th width="85%">Sitemap</th>
						<th width="15%">Last Modified</th>
					</tr></thead>
					<tbody>
					<xsl:for-each select="sitemap:sitemapindex/sitemap:sitemap">
						<xsl:variable name="sitemapURL">
							<xsl:value-of select="sitemap:loc"/>
						</xsl:variable>
						<tr>
							<td>
								<a>
									<xsl:attribute name="href">
										<xsl:value-of select="sitemap:loc"/>
									</xsl:attribute>
									<pre><xsl:value-of select="sitemap:loc"/></pre>
								</a>
							</td>
							<td>
								<xsl:value-of select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,5)),concat(' ', substring(sitemap:lastmod,20,6)))"/>
							</td>
						</tr>
					</xsl:for-each>
					</tbody>
					<tfoot><tr>
						<td colspan="2">
							<small>This XML Sitemap Index file contains <xsl:value-of select="count(sitemap:sitemapindex/sitemap:sitemap)"/> sitemaps.</small>
						</td>
					</tr></tfoot>
				</table>
			</xsl:if>
			<xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &lt; 1">
				<table>
					<thead><tr>
						<th width="80%">URL</th>
						<th width="5%">Images</th>
						<th title="Last Modification Time" width="15%">Last Mod.</th>
					</tr></thead>
					<tbody>
					<xsl:variable name="lower" select="'abcdefghijklmnopqrstuvwxyz'"/>
					<xsl:variable name="upper" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/>
					<xsl:for-each select="sitemap:urlset/sitemap:url">
						<tr>
							<td>
								<xsl:variable name="itemURL">
									<xsl:value-of select="sitemap:loc"/>
								</xsl:variable>
								<a>
									<xsl:attribute name="href">
										<xsl:value-of select="sitemap:loc"/>
									</xsl:attribute>
									<pre><xsl:value-of select="sitemap:loc"/></pre>
								</a>
							</td>
							<td>
								<xsl:value-of select="count(image:image)"/>
							</td>
							<td>
								<xsl:value-of select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,5)),concat(' ', substring(sitemap:lastmod,20,6)))"/>
							</td>
						</tr>
					</xsl:for-each>
					</tbody>
					<tfoot><tr>
						<td colspan="3">
							<small>This XML Sitemap contains <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> URLs.</small>
						</td>
					</tr></tfoot>
				</table>
			</xsl:if>
			<p class="text-center"><abbr title="Vino Rodrigues">&#169; 2020</abbr></p>
		</div>
		</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
