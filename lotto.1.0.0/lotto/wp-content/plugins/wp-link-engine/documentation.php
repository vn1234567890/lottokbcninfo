<?php
function wplink_help() {
?>
 <div class="wrap">
                <div id="icon-edit" class="icon32"><br /></div>
                <h2>Documentation</h2>
                
                <p>Link Engine is the single most powerful plugin for managing affiliate and business links.</p>
                
                <p>When installed the script adds a menu to the left side of your WordPress install (as seen right now); within this menu is where most of your link management is contained. On the "manage links" page, you can create, edit, delete, clone and generate links. The "presets" page lets you delete saved presets (you save these when you create a link on the create link page &mdash; under "manage").</p>
                
                <h3>Creating a link...</h3>
                
                <p>On the manage links page you'll see a link at the top left called "Create Link." Click this and you'll be brought to the full create link form. This form has all the menus necessary to create effective links and contains most of the script itself.</p>
                
                <p>Each of the little [+] menus contains additional functionality. Check them out, and read on for more information.</p>
                
                <h3>How slugs / subids work.</h3>
                <p>When you specify a slug, you're telling Link Engine to take [yoursite.com]/your-new-slug as the URL for the link you're generating. If you specify nothing else, that URL will become a "mask" for the To: URL you specify right below it; however, that would hardly take advantage of all the great features of Link Engine.</p>
                
                <p>All slugs that have subid tracking enabled (specified under "Link Destination Options") will also work as [yoursite.com]/your-new-slug/subid where "subid" is any value you want. This allows you to track new traffic sources without ever even signing in to the link manager. You can check out these statistics in the Statistics menu on the sidebar.</p>
                
                <p>Slugs that match the slugs of existing posts may cause unfixable problems. Please try not to have posts with the same slug as your link. Slugs which have names like "index.php" or "archives" will not work - please keep your slugs away from any reserved WordPress keywords.</p>
                
                <h3>Split Testing</h3>
                <p>Want to split test links? Specify multiple URLs with any rotation frequency you want: by default, they're split tested evenly, but right to the right of your URL box you can specify any percentage you want.</p>
                
                <h3>Multiple Destinations</h3>
                <p>Multiple destinations links only work when they're filtered either through the "Link Matching" system, or when they're generated with the shortcode (jump down to the "shortcodes" section below). Specify multiple URLs, one per line, and the script will generate a link which pops up all the URLs upon click AND your to: location loads in the background.</p>
                
                <h3>Controlling / Restricting Your Link</h3>
                <p>If you click on "Link Restrictions" you'll find that you can ban user's by hostname, IP address or referrer; and even better, rather than directly banning them you can just point them to more... friendly landing pages. The main use for this is rather black hat; redirecting people who are approving your ads such as <a href="http://ws.arin.net/whois/?queryinput=facebook">Facebook</a> or any other company to ads they're more likely to approve. This allows you a competitive advantage by getting traffic sources that aren't going to be dropped. Use a raw 301 redirect instead of a more complicated redirect and you can even use this for images. :-) Find registered IP addresses for a company by searching the <a href="http://ws.arin.net/whois/">ARIN WHOIS</a>, or simply run an ad and determine patterns in the approval addresses. <strong>This is often a violation of advertisment networks' terms of service and can result in a ban, please be aware of what you are getting in to.</strong></p>
                
                <p>In Link Engine 2.0, you can simply specify a company name and have the ARIN data found automatically. In the "intelligent company range" field enter a name such as "google" and it will automatically run <a href="http://ws.arin.net/whois/?queryinput=-%20google">this ARIN query</a> and handle all the returned IP addresses. Please test your ARIN queries.</p> 
                <h3>Cloaking Functionality</h3>
                <ul>
                    <li><strong>301 Redirect</strong> - this is a standard redirect, with no cloaking options enabled. Generally, this means referrer information will be sent to your end users. Literally, this means "Moved Permanently" and some browsers will cache the new destination rather than re-request this URL.</li>
                    
                    <li><strong>302 Redirect</strong> - much like 301 redirects, this won't affect referrer information usually. This means "Found" in HTTP lingo, which means that the requested URL is not cacheable and is generally considered "temporary."</li>
                    
                    <li><strong>307 Redirect</strong> - much like 301 and 302 redirects, this won't affect referrer information usually. This literally means "Moved Temporarily," meaning this URL will be re-requested in the future in case the redirection URI has changed. This is preferable most of the time.</li>
                    
                    <li><strong>Double Meta Refresh</strong> - the standard and most common way of clearing the referrer. This works to send no referrer from Internet Explorer and Firefox users, but may not clear the referrer with other browsers, sometimes.</li>
                    
                    <li><strong>Javascript Redirect</strong> - this requires the user to have JS enabled. The redirect happens very quickly, but does load an intermediary page. May sometimes clear referrer.</li>

                    <li><strong>Javascript -> Meta</strong> - another popular method, this redirects from a Javascript redirect to a double meta refresh redirect. Combining two popular methods, both of which are quite fast to attempt to more completely clear the referrer.</li>

                    <li><strong>Framed Page</strong> - rather than clear referrers, this method masks the URL. An end user will see your slug'd URL rather than the destination's URL. Sometimes, the destination may do what is called "breaking the frame" in which case, this will work, but will immediately be redirected to a new page.</li>
                    
                    <li><strong>Guaranteed Wipe</strong> - this will NEVER send a referrer to the end destination. Ever. Test it yourself if you don't believe me (if you're doing something particularly iffy, you really should test it yourself &mdash; but in dozens of tests, it does not send a referrer). What this does &mdash; it loops through all the methods above (and variations), testing to see if its cleared the referrer, if it gets through them all (which it often does) and fails to clear the referrer, it'll redirect to the URL you specified in "Extra Cloaking Information" for the alternate URL. The Alternate URL should be one of your own sites or an advertiser that doesn't care that you're sending the type of traffic you are, since the referrer will be sent 100% of the time to that destination.</li>
                    
                    <li><strong>Custom HTML</strong> - if you upload a custom-redirects.php to the redirects/ folder which uses the variable <code>$destination</code> to determine the new destination, you can define your own redirect method.</li>
                </ul>
                <h3>Automatch Links</h3>
                <p>The functionality of the automatch links block allows you to control links (such as adding class, titles, and multiple link destinations - as well as changing the URLs to your prettyized URLs) that already exist within a WordPress blog. That is, you can match existing URLs - such as the destination URL or any other URL, and replace it with the link. You usually don't want any except the two checkboxes that are pre-checked (unless you want to uncheck those), because the other links will result in links who's destination is different than before the replacement. You can disable this per-post.</p>

                <h3>Short Tags</h3>
                <p>For any link you've created, an "ID" is associated with it. You can see this ID on the manage links page. To create a short tag, you can use [lel id="x"] where, 'x' is the ID. Alternatively, you can specify a link text to be used instead of the link text defined for the link by going [lel id="x"]click here[/lel]. You can also pass a "subid" to it if you'd like to track a subid, such that the code would look like [lel subid="toplink" id="1"]CLICK HERE[/lel] or so. </p>

                <h3>Bulk Editing</h3>
                <p>Bulk adding IP addresses within the interface allows you to simply paste a list of IP addresses and have them all redirected to a given destination. For this to work right, make sure you specify the destination immediately under the bulk box. Users with more advanced needs can generate bulk lists with pipe characters ( | ) to separate the IP and destination; please specify a default destination no matter what, even if you define a destination for every line.</p>
                <p>To prevent accidents, the bulk editing box will cowardly refuse to process if you have one or fewer lines. This is for BULK data insertion, use the IP/Company Options Manager to specify individual IPs.</p>

 </div>
                
<?php
}
?>