<?php
// Readingtime extension, https://github.com/schulle4u/yellow-readingtime

class YellowReadingtime {
    const VERSION = "0.9.1";
    public $yellow;         // access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("readingtimeWordsPerMinute", "250");
    }
    
    // Handle page content element
    public function onParseContentElement($page, $name, $text, $attributes, $type) {
        $output = null;
        if ($name=="readingtime" && ($type=="inline")) {
            list($wordsPerMinute) = $this->yellow->toolbox->getTextArguments($text);
            if (is_string_empty($wordsPerMinute) || (!is_numeric($wordsPerMinute))) $wordsPerMinute = $this->yellow->system->get("readingtimeWordsPerMinute");
            $content = strip_tags($page->getContentHtml());
            $wordCount = $this->yellow->toolbox->getTextWords($content);
            $output .= "<span class=\"".htmlspecialchars($name)."\">".ceil($wordCount / $wordsPerMinute)."</span>";
        }
        return $output;
    }
}
