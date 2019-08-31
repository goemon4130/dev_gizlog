<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DailyReport;
use App\Http\Requests\User\DailyReportRequest;
use Auth;

class DailyReportsController extends Controller
{
    private $dailyReport;

    public function __construct(DailyReport $dailyReport)
    {
        $this->middleware('auth');
        $this->dailyReport = $dailyReport;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputMonth = $request->query('search-month');
        if (isset($inputMonth))
        {
            $dailyReports = $this->dailyReport->dateSearch($inputMonth);
            return view('user.daily_report.index', compact('dailyReports'));
        } else {
            $dailyReports = $this->dailyReport->getAll();
            return view('user.daily_report.index', compact('dailyReports'));
        }
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
    public function store(DailyReportRequest $request)
    {
        $inputDailyReport = $request->all();
        $inputDailyReport['user_id'] = Auth::id();
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
    public function update(DailyReportRequest $request, $id)
    {
        $inputDailyReport = $request->all();
        $this->dailyReport->find($id)->fill($inputDailyReport)->save();
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
}
