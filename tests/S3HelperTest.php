<?php

use App\Helpers\S3Helper;

class S3HelperTest extends TestCase
{
    public function testFull()
    {
        $s3 = new S3Helper('minsal-documentos');

        $key = $s3->put('tests/sample.pdf');

        echo $s3->getUrl($key);

    }

}
