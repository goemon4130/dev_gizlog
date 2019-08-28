<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DailyReport;

class DailyReportsController extends Controller
{
    public function __construct(DailyReport $instanceclass)
    {
        $this->dailyReport = $instanceclass;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dailyReports = $this->dailyReport->get();
        return view('user.daily_report.index', compact('dailyReports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.daily_report.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'reporting_time' => 'required|date',
            'title' => 'required|string',
            'content' => 'required|string'
        ]);
        $input = $request->all();
        $this->dailyReport->fill($input)->save();
        return redirect()->to('dailyreports');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dailyReport = $this->dailyReport->find($id);
        return view('user.daily_report.show', compact('dailyReport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dailyReport = $this->dailyReport->find($id);
        return view('user.daily_report.edit', compact('dailyReport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'reporting_time' => 'required|date',
            'title' => 'required|string',
            'content' => 'required|string'
        ]);
        $input = $request->all();
        $this->dailyReport->find($id)->fill($input)->save();
        return redirect()->to('dailyreports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->dailyReport->find($id)->delete();
        return redirect()->to('dailyreports');
    }

    public function dateSearch(Request $request)
    {
        $input = $request->query('search-month');
        $dailyReports = $this->dailyReport->where('reporting_time', 'like', $input. '%')->get();
        return view('user.daily_report.index', compact('dailyReports'));
    }
}
