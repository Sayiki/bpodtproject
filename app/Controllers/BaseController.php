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
        // Get the current URI
        $uri = service('uri');

        // Check if we're not on an admin page
        if (!$this->isAdminPage($uri)) {
            $visitorModel = new VisitorModel();
            $visitorModel->incrementDailyVisits();
        }
    }

    private function isAdminPage($uri)
    {
        // Adjust this condition based on your admin URL structure
        return $uri->getSegment(1) === 'admin' || $uri->getSegment(1) === 'dashboard' || $uri->getSegment(1) === 'form_data' || $uri->getSegment(1) === 'tampil_data';
    }


}
