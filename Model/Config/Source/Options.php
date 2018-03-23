<?php
namespace Absoft\WallCatalog\Model\Config\Source;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;
class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource {

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options= [
            ['label'=>'Default','value'=>'default'],
            ['label'=>'Wall Art','value'=>'wall_art'],
            ['label'=>'Wall Decal','value'=>'wall_decal'],
            ['label'=>'Wall Paper','value'=>'wall_paper']
        ];
        return $this->_options;
        // TODO: Implement getAllOptions() method.
    }
}