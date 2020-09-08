<?php


namespace App\Http\Service\Crawler;


interface MediumCrawlerPattern {

    const MEDIUM_ROOT_URL = "https://medium.com/hackernoon/";
    const LOAD_MORE_URL = self::MEDIUM_ROOT_URL . "load-more?sortBy=tagged&tagSlug=%s&limit=%s";


    const TITLE_LINK_OVERVIEW = '|{"id":".*","versionId":".*","creatorId":".*","homeCollectionId":".*","title":"(.*)","detectedLanguage":".*","latestVersion":".*","latestPublishedVersion":".*","hasUnpublishedEdits.*"uniqueSlug":"(.*),"|U';


    const DETAIL_TITLE = '|{"success":[a-zA-Z]*,"payload":{"value":{"id":".*","versionId":".*","creatorId":".*","homeCollectionId":"[a-zA-Z0-9]*","title":"(.*)","detectedLanguage":"en"|U';


    const DETAIL_TITLE_HTML = '|class="fo fp fq fr b fs ft fu fv fw fx fy fz ga gb gc gd ge gf gg gh ec">(.*)</h1>|U';


    const DETAIL_TAG = '|{"slug":"[A-Za-z0-9]*","name":"([A-Za-z0-9]*)","postCount":[0-9]*,"metadata":{"postCount":[0-9]*,"coverImage":.*},"type":"Tag"}|mU';


    const DETAIL_TAG_HTML = '|<a href="(.*)" class="ce cf cg kk hv sw sx hu r sy">(.*)</a>|U';


    const DETAIL_CREATOR = '|"User":.*"name":"(.*)","username"|U';


    const DETAIL_CREATOR_HTML = '|<a class="cl cm at au av aw ax ay az ba he bd ei ej" rel="noopener" href="(.*)">(.*)</a>|U';


    const DETAIL_DATA = '|{"name":".*","type":[0-9]*,"text":"(.*)","markups"|U';


    const DETAIL_DATA_HTML = '|<div><a class="cl cm at au av aw ax ay az ba he bd ei ej" rel="noopener" href="(.*)">(.*)</a> <!-- -->·<!-- --> <!-- -->(.*)<!-- -->(.*)</div>|U';


    const DETAIL_RESPONSE = '';


    const DETAIL_RESPONSE_HTML = '|class="fo fp fq fr b fs ft fu fv fw fx fy fz ga gb gc gd ge gf gg gh ec">(.*)</h1>|U';

    const DETAIL_READ_TIME = '|"wordCount":[0-9]*,"imageCount":[0-9]*,"readingTime":(.*),"subtitle":|U';

}
