<?php
namespace Absoft\WallCatalog\Plugin;

class RestApiLog {

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }

    public function beforeDispatch(
        \Magento\Webapi\Controller\Rest $subject,
        \Magento\Framework\App\RequestInterface $request
    ) {

        $string = "params:{$request->getContent()}";
        $this->_logger->info($string);

    }


}