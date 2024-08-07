<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\WisataModel;
use App\Models\VisitorModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->trackVisit();
    }

    private function trackVisit()
    {
        $uri = service('uri');
        $request = service('request');

        $currentPath = $uri->getPath();
        $ipAddress = $request->getIPAddress();

        log_message('debug', 'Attempting to track visit for URI: ' . $currentPath . ' from IP: ' . $ipAddress);

        if (!$this->isAdminPage($uri)) {
            $visitorModel = new \App\Models\VisitorModel();
            $visitorModel->incrementDailyVisits($ipAddress);
            log_message('debug', 'Visit processed for URI: ' . $currentPath . ' from IP: ' . $ipAddress);
        } else {
            log_message('debug', 'Visit not counted - admin page detected for URI: ' . $currentPath);
        }
    }
    

    private function isAdminPage($uri)
    {
        $segments = $uri->getSegments();
        $segment1 = $segments[0] ?? '';
        $segment2 = $segments[1] ?? '';

        $excludedPages = ['admin', 'dashboard', 'form_data', 'tampil_data', 'login', 'logout', ''];

        if (in_array($segment1, $excludedPages)) {
            return true;
        }

        // Check for "detail/something" pattern
        if ($segment1 === 'detail' && $segment2 !== '') {
            return true;
        }

        return false;
    }


}
