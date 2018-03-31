<?php
namespace Absoft\WallCatalog\Model;

use Magento\Framework\App\Filesystem\DirectoryList;

class UploadImage implements \Absoft\WallCatalog\Api\Data\UploadImageInterface {


    protected $mediaDirectoryWrite;

    public function __construct(
        \Magento\Framework\Filesystem $filesystem

    )
    {
        $this->mediaDirectoryWrite = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);

    }

    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string.
     */
    public function upload($base64)
    {

        $image_data = explode(',',$base64)[1];
        $dir = '/wallcatalog/cart/';
        $file_name = time().'.jpg';
        $output_file = $dir.$file_name;
        if($this->mediaDirectoryWrite->writeFile($output_file,base64_decode($image_data))){
            $res['success']=true;
            $res['img']=$file_name;
            echo json_encode($res);
        };

        // TODO: Implement upload() method.
    }
}