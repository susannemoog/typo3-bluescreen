<?php
declare(strict_types = 1);

namespace Susanne\Bluescreen\Error;


use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\View\TemplatePaths;
use TYPO3Fluid\Fluid\View\TemplateView;

class ProductionExceptionHandler extends \TYPO3\CMS\Core\Error\ProductionExceptionHandler
{
    /**
     * The view object
     *
     * @var TemplateView
     */
    protected $view;
    /**
     * @var int
     */
    protected $severity;

    /**
     * Echoes an exception for the web.
     *
     * @param \Throwable $exception The throwable object.
     */
    public function echoExceptionWeb(\Throwable $exception)
    {
        $this->sendStatusHeaders($exception);
        $this->writeLogEntries($exception, self::CONTEXT_WEB);
        $this->view = GeneralUtility::makeInstance(TemplateView::class);
        $context = new RenderingContext($this->view);
        $context->setControllerName('ErrorPage');
        $context->setTemplatePaths(new TemplatePaths([
            'templateRootPaths' => [
                Environment::getExtensionsPath() . '/bluescreen/res/private/template/error/',
            ],
        ]));
        $this->view->setRenderingContext($context);
        $this->severity = AbstractMessage::ERROR;
        $classes = [
            AbstractMessage::NOTICE => 'notice',
            AbstractMessage::INFO => 'information',
            AbstractMessage::OK => 'ok',
            AbstractMessage::WARNING => 'warning',
            AbstractMessage::ERROR => 'error',
        ];
        $this->view->assign('severityCssClass', $classes[$this->severity]);
        $this->view->assign('severity', $this->severity);
        $this->view->assign('message', $this->getMessage($exception));
        $this->view->assign('title', $this->getTitle($exception));
        $this->view->assign('errorCodeUrlPrefix', TYPO3_URL_EXCEPTION);
        $this->view->assign('errorCode', $this->discloseExceptionInformation($exception) ? $exception->getCode() : 0);
        $this->view->assign('cssFile', PathUtility::getAbsoluteWebPath(Environment::getExtensionsPath() . '/bluescreen/res/public/css/errorpage.css'));
        echo $this->view->render('Error');
    }

}
