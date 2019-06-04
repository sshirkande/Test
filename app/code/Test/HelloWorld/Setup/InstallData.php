<?php 

namespace Test\HelloWorld\Setup;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\Data\BlockInterfaceFactory;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Store\Model\Store;
class InstallData implements InstallDataInterface
{
    /** @var  BlockRepositoryInterface */
    private $blockRepository;
    /** @var BlockFactory */
    private $blockInterfaceFactory;
    /** @var State */
    private $state;
  
  /**
     * InstallData constructor.
     * @param BlockRepositoryInterface $blockRepository
     * @param BlockInterfaceFactory $blockInterfaceFactory
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockInterfaceFactory $blockInterfaceFactory,
        State $state
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockInterfaceFactory = $blockInterfaceFactory;
        $this->state = $state;
    }
  
  /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
            /** set Area code to prevent the Exception during setup:upgrade */
            $this->state->setAreaCode(Area::AREA_ADMINHTML);
      
            /** @var BlockInterface $cmsBlock */
            $cmsBlock = $this->blockInterfaceFactory->create();
            $content = <<<HTML
<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse mauris tortor, 
rhoncus at diam ac, aliquet egestas elit. Integer varius, ipsum et imperdiet scelerisque, 
lorem magna feugiat arcu, sed rhoncus velit magna a velit.</div> 
HTML;
            $cmsBlock->setIdentifier('my_custom_identifier');
            $cmsBlock->setTitle('my_custom_title');
            $cmsBlock->setContent($content);
            $cmsBlock->setData('stores', [Store::DEFAULT_STORE_ID]); // DEFAULT_STORE_ID = 0
            $this->blockRepository->save($cmsBlock);   
    }
}
