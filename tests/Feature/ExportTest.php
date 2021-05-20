<?php

namespace MediaConvert\Tests\Feature;

use MediaConvert\Models\Common;
use MediaConvert\Models\Export;

class ExportTest extends TestCase
{
    public function testImportUrl()
    {
        // init
        $export = (new Export('export/url'))
            ->set('input', '2w2y610m-awgo-bt8q-cq2p-981fu1w1bmr0');
        $this->mediaConvert->exports()->create($export);
        $this->assertNotNull($export->getId());
        $this->assertNotNull($export->getCreatedAt());
        $this->assertEquals('export/url', $export->getOperation());
        $this->assertEquals([
            'input' => '2w2y610m-awgo-bt8q-cq2p-981fu1w1bmr0',
        ], (array)$export->getPayload());
        $this->assertEquals(Common::STATUS_WAITING, $export->getStatus());

        // info
        $this->mediaConvert->exports()->info($export);
        $this->assertEquals(Common::STATUS_SUCCESS, $export->getStatus());

        // url
        $this->assertNotEmpty($export->getResult()->files[0]->url ?? '');

        // download
        $source = $this->mediaConvert->getHttpTransport()->download($export->getResult()->files[0]->url)->detach();

        $dest = tmpfile();
        $destPath = stream_get_meta_data($dest)['uri'];
        stream_copy_to_stream($source, $dest);
        $this->assertEquals(filesize($destPath), $export->getResult()->files[0]->size);
    }
}
