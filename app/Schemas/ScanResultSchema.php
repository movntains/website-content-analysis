<?php

declare(strict_types=1);

namespace App\Schemas;

use Prism\Prism\Schema\ArraySchema;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;

class ScanResultSchema
{
    public static function create(): ObjectSchema
    {
        return new ObjectSchema(
            name: 'url_scan_result',
            description: 'A structured response for a URL scan result',
            properties: [
                new StringSchema('extracted_content', 'The HTML content extracted from the URL'),
                new NumberSchema('clarity_score', 'A score from 0 to 100 indicating the clarity of the content'),
                new NumberSchema('consistency_score', 'A score from 0 to 100 indicating the consistency of the content'),
                new NumberSchema('seo_score', 'A score from 0 to 100 indicating the SEO of the content'),
                new NumberSchema('tone_score', 'A score from 0 to 100 indicating the tone of the content'),
                new StringSchema('clarity_analysis', 'A detailed analysis of the clarity of the content'),
                new StringSchema('consistency_analysis', 'A detailed analysis of the consistency of the content'),
                new StringSchema('seo_analysis', 'A detailed analysis of the SEO of the content'),
                new StringSchema('tone_analysis', 'A detailed analysis of the tone of the content'),
                new ArraySchema(
                    name: 'suggested_headlines',
                    description: 'A list of suggested headlines for the content',
                    items: new StringSchema('suggested_headline', 'A suggested headline')
                ),
                new ArraySchema(
                    name: 'suggested_ctas',
                    description: 'A list of suggested CTAs for the content',
                    items: new StringSchema('suggested_cta', 'A suggested CTA')
                ),
                new ArraySchema(
                    name: 'suggested_content_hierarchy',
                    description: 'A suggested hierarchy for the content',
                    items: new StringSchema('suggested_hierarchy_item', 'A suggested content item')
                ),
            ]
        );
    }
}
