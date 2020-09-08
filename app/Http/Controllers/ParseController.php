<?php

namespace App\Http\Controllers;

use App\Http\Service\BlogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ParseController extends Controller
{

    private BlogService $blogService;


    /**
     * ParseController constructor.
     */
    public function __construct() {
        $this->blogService = new BlogService();
    }

    /**
     * Delegates the request of fetching title to the BlogService
     * @param Request $request
     * @return JsonResponse
     */
    public function parseMediumOverview(Request $request) {
        $data = $this->blogService->getTitles($request->input('keyword'), $request->input('next'));
        return response()->json(json_encode($data));
    }

    /**
     * Delegates the retrieval of blog data to BlogService which inturn decides whether to fetch blog data from
     * crawler or database.
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function parseBlog(string $slug) {
        $fetchedData = $this->blogService->getBlog($slug);
        $demo = json_decode($fetchedData['data']);
        $fetchedData['data'] = $demo;
        return view('blog-detail')->with('data', $fetchedData);
    }

}
