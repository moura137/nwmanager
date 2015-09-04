<?php

namespace NwManager\Http\Controllers\App;

use NwManager\Http\Controllers\Controller;
use NwManager\Api\ApiRequest;
use Illuminate\Http\Request;

/**
 * Class ProjectController
 *
 * @package NwManager\Http\Controllers;
 */
class ProjectController extends Controller
{
    /**
     * Construct ProjectController
     *
     * @param ApiRequest $api
     */
    public function __construct(ApiRequest $api, Request $request)
    {
        $this->api = $api;
        $this->request = $request;
    }

    public function index()
    {
        $projects = $this->api->get('project');
        return view('app.projects.index', compact('projects'));
    }

    public function show($id)
    {
        $project = $this->api->get("project/{$id}");
        return view('app.projects.show', compact('project'));
    }

    public function edit($id)
    {
        $project = $this->api->get("project/{$id}");
        return view('app.projects.edit', compact('project'));
    }

    public function update($id)
    {
        $data = $this->request->all();
        $result = (array) $this->api->put("project/{$id}", $data);

        if (isset($result['error'])) {
            $errors = (array) $result['error_description'];

            return redirect()
                ->route('app.project.edit', $id)
                ->withInput()
                ->withErrors($errors);
        }

        return redirect()
            ->route('app.project.show', $id)
            ->with('alert_success', trans('messages.update_success'));
    }

    public function create()
    {
        return view('app.projects.create');
    }

    public function store()
    {
        $data = $this->request->all();
        $result = (array) $this->api->post("project", $data);

        if (isset($result['error'])) {
            $errors = (array) $result['error_description'];

            return redirect()
                ->route('app.project.create')
                ->withInput()
                ->withErrors($errors);
        }

        return redirect()
            ->route('app.project.index')
            ->with('alert_success', trans('messages.store_success'));
    }

    public function delete($id)
    {
        $project = $this->api->get("project/{$id}");
        return view('app.projects.delete', compact('project'));
    }

    public function destroy($id)
    {
        $result = (array) $this->api->delete("project/{$id}");

        if (isset($result['error'])) {
            $errors = (array) $result['error_description'];

            return redirect()
                ->route('app.project.delete', $id)
                ->withInput()
                ->withErrors($errors);
        }

        return redirect()
            ->route('app.project.index')
            ->with('alert_success', trans('messages.delete_success'));
    }
}
