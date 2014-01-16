<?php

// jinclude imports joomla framework
require_once "jinclude.php";
require_once "jutils.php";

$twitter_config = array("consumer_key"     => $componentParams->get('twitter_consumer_key', ""),
                 "consumer_secret"  => $componentParams->get('twitter_consumer_secret', ""),
                 "access_token"     => $componentParams->get('twitter_access_token', ""),
                 "access_secret"    => $componentParams->get('twitter_access_secret', ""),
                 "username"         => $componentParams->get('twitter_username', ""),
                 "maximum"          => $componentParams->get('twitter_maximum', 10),
                 "caching"          => $componentParams->get('twitter_caching', 60),
                 "autopublish_feed" => $componentParams->get('autopublish_feed', 1));
 

// I check if the category exists
$category_id = checkCategoryExists("twitter");
if(!$category_id)
{
    // If autocreate_categories is true I can create the category and save the feed
    if($componentParams->get('autocreate_categories', TRUE))
    {
        $category_id = createJoomlaCategory("com_content", "Twitter", "twitter");
    }
    else
    {
        // The category doesn't exists. Where do I save the article?
        die();
    }
}

// API Keys
$consumerKey       = $twitter_config["consumer_key"];
$consumerSecret    = $twitter_config["consumer_secret"];
$accessToken       = $twitter_config["access_token"];
$accessTokenSecret = $twitter_config["access_secret"];

// Details
$username = $twitter_config["username"];
$maximum  = $twitter_config["maximum"];
$caching  = $twitter_config["caching"];

$filename = basename(__FILE__, '.php').'.json';
$filetime = file_exists($filename) ? filemtime($filename) : time() - $caching - 1;

if (time() - $caching > $filetime) {
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$base = 'GET&'.rawurlencode($url).'&'.rawurlencode("count={$maximum}&oauth_consumer_key={$consumerKey}&oauth_nonce={$filetime}&oauth_signature_method=HMAC-SHA1&oauth_timestamp={$filetime}&oauth_token={$accessToken}&oauth_version=1.0&screen_name={$username}");
	$key = rawurlencode($consumerSecret).'&'.rawurlencode($accessTokenSecret);
	$signature = rawurlencode(base64_encode(hash_hmac('sha1', $base, $key, true)));
	$oauth_header = "oauth_consumer_key=\"{$consumerKey}\", oauth_nonce=\"{$filetime}\", oauth_signature=\"{$signature}\", oauth_signature_method=\"HMAC-SHA1\", oauth_timestamp=\"{$filetime}\", oauth_token=\"{$accessToken}\", oauth_version=\"1.0\", ";

	$curl_request = curl_init();
	curl_setopt($curl_request, CURLOPT_HTTPHEADER, array("Authorization: Oauth {$oauth_header}", 'Expect:'));
	curl_setopt($curl_request, CURLOPT_HEADER, false);
	curl_setopt($curl_request, CURLOPT_URL, $url."?screen_name={$username}&count={$maximum}");
	curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($curl_request);
	curl_close($curl_request);

	file_put_contents($filename, $response);
} else {
	$response = file_get_contents($filename);
}

header('Content-Type: application/json');
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $filetime).' GMT');

$jTfeeds = json_decode($response);

foreach($jTfeeds as $tweet) {    
    // If the item has not been imported yet
    if(!checkArticleAlreadyImported($tweet->id_str))
    {
        // URL generating... (example: https://twitter.com/rexromae/statuses/390802730769321984)
        $tweet_url = "https://twitter.com/".$tweet->user->screen_name."/statuses/".$tweet->id_str;
        
        $data = array(
            'catid'      => $category_id,
            'title'      => cutTweetTitle($tweet->text, 30),
            'introtext'  => cutTweetTitle($tweet->text, 30),
            'fulltext'   => $tweet->text,
            'state'      => $twitter_config["autopublish_feed"],
            'urls'       => '{"urla":"'.  htmlspecialchars($tweet_url).'","urlatext":"","targeta":"1","urlb":false,"urlbtext":"","targetb":"","urlc":null,"urlctext":"","targetc":""}',
            'metadata'   => '{{"robots":"Activategrid","author":"'.$tweet->user->screen_name.'","rights":"","xreference":"'.$tweet_url.'"}}',
            'xreference' => $tweet->id_str,
        );

        //print_r($data);
            echo $tweet->text."\n\n";
            createJoomlaArticle($data);
    }
}

function cutTweetTitle($title, $max_chars)
{
    if(strlen($title) > $max_chars)
    {
        return substr($title, 0, $max_chars)."...";
    }
    else
        return $title;    
}







function prettyPrint( $json )
{
    $result = '';
    $level = 0;
    $prev_char = '';
    $in_quotes = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if( $char === '"' && $prev_char != '\\' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
        $prev_char = $char;
    }

    return $result;
}