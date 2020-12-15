<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const AUTH_REDIRECT_TO = '/labs';

    public $viewName;

    /**
     * Current controller name
     * @var mixed|string
     */
    public $ctrlName;
    public $redirectToUrl;

    public function __construct()
    {
        $this->viewName = request()->route()->getName();
        $this->ctrlName = AppHelper::getCurrentControllerName(get_called_class());
        $this->redirectToUrl = $this->ctrlName.'.index';

        View::share('ctrlName', $this->ctrlName);
    }

    protected function getRedirectWith($result, $ctrlName)
    {
        if ($result) {
            return redirect(route($ctrlName))->with('success', __('SuccessOperation'));
        }
        return redirect(route($ctrlName))->with('error', __('FailedOperation'));
    }

}
