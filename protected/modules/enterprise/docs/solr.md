# SOLR Search Support


## Add to common.php - components section

        'search' => [
            'class' => 'humhub\modules\enterprise\modules\solr\engine\SolrSearch',
            'host' => 'solr.hosts.humhub.net',
            'port' => 80,
            'path' => '/core/testing/',
            'username' => 'humhub',
            'password' => 'humhub',
        ],
