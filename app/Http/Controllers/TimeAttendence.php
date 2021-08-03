<?php

namespace App\Http\Controllers;

use App\Models\BeneatUser;
use App\Models\Holiday;
use App\Models\LeaveData;
use App\Models\LeaveQuota;
use App\Models\Time;

use App\Models\users;
use App\Models\WorkFromHome;
use App\Models\WorkHoliday;
use Illuminate\Http\Request;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Carbon;

class TimeAttendence extends Controller
{
    public function test(Request $request)
    {
        $thisTime = date('H:i:s');
        $thisDate = date('Y-m-d');

        $timearr = Time::whereDate('start_date', '=', $thisDate)->get();

        if ($timearr->isNotEmpty()) {
            foreach ($timearr as $key => $item) {
                $item->end_time = $thisTime;
                $item->end_date = $thisDate;
                $item->save();
            }
        }

        return response()->json($timearr);
    }

    public function index(Request $request)
    {

        //dd($request->all);
        $id = $request->id;
        //$time = Time::all();
        $time = Time::where('user_id', '=', $id)->get();
        return response()->json($time);
    }
    public function postphotourl(Request $request)
    {
        $photoUrl = $request->photoUrl;
        $email = $request->email;


        $user = BeneatUser::where('email','=',$email)->first();
        $user->photo = $photoUrl;

        $user->save();
        return response()->json($user);

    }

    public function leaveloadedit(Request $request)
    {

        //dd($request->all);
        $id = $request->id;
        //$time = Time::all();
        $leavedataedit = LeaveData::where('id', '=', $id)->first();
        return response()->json($leavedataedit);
    }

    public function leavequota(Request $request)
    {

        //dd($request->all);
        $id = $request->id;
        //$time = Time::all();
        $leavequota = LeaveQuota::where('user_id', '=', $id)->get();
        return response()->json($leavequota);
    }

    public function checkInPagination(Request $request)
    {

        //dd($request->all);
        $id = $request->id;
        $page = $request->offsetPage;
        //$time = Time::all();
        $time = Time::where('user_id', '=', $id)
            ->offset($page)
            ->limit(15)
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json($time);
    }

    public function id(Request $request)
    {

        //dd($request->all);
        $email = $request->email;
        // $time = BeneatUser::all();
        $id = BeneatUser::select('user.*', 'department.name as departmentName')
            ->join('department', 'department.id', '=', 'user.department_id')
            ->where('email', '=', $email)->first();
        return response()->json($id);
    }

    public function leaveDataPerson(Request $request)
    {
        $id = $request->id;

        //$leaveData = LeaveData::all();
        $leaveData = LeaveData::select('leave.*', 'admin.name as adminName')
            ->leftjoin('user as admin', 'leave.approve_id', '=', 'admin.id')
            ->where('user_id', '=', $id)
            ->get();

        return response()->json($leaveData);

    }

    public function destroy($id)
    {
        $leaveData = LeaveData::find($id)->delete();

        return response()->json($leaveData);
    }

    public function leaveDataPersonPagnigation(Request $request)
    {
        $page = $request->offsetPage;
        $id = $request->id;

        //$leaveData = LeaveData::all();
        $leaveData = LeaveData::select('leave.*', 'admin.name as adminName')
            ->leftjoin('user as admin', 'leave.approve_id', '=', 'admin.id')
            ->where('user_id', '=', $id)
            ->offset($page)
            ->limit(15)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($leaveData);

    }

    public function timeattendenthistorypanigationfortimeline(Request $request)
    {
        $page = $request->offsetPage;
        $id = $request->id;

        $time = Time::where('user_id', '=', $id)
            ->offset($page)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->first();
        return response()->json($time);

    }

    public function leavedatapanigationfortimeline(Request $request)
    {
        $page = $request->offsetPage;
        $id = $request->id;

        $leave = LeaveData::where('user_id', '=', $id)
            ->offset($page)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->first();
        return response()->json($leave);

    }

    public function leaveDataDepartment(Request $request)
    {
        $departmentName = $request->departmentName;

        $thisYear = date('Y');
        //$leaveData = LeaveData::all();
        $leaveData = LeaveData::select('leave.*', 'user.name',
            'department.name as departmentName',
            'admin.name as adminName'
        )
            ->join('user', 'leave.user_id', '=', 'user.id')
            ->leftjoin('user as admin', 'leave.approve_id', '=', 'admin.id')
            ->join('department', 'department.id', '=', 'user.department_id')
            ->where('department.name', '=', $departmentName)
            ->where('leave_status', '=', 'อนุมัติ')
            ->whereYear('start_date','=', $thisYear)
            ->get();


        return response()->json($leaveData);

    }

    public function historyData(Request $request)
    {

    }

    public function holiday(Request $request)
    {
        $thisYear = date('Y');

        $time = Holiday::whereYear('start_date', '=', $thisYear)
            ->get();
        return response()->json($time);
    }

    public function workholiday(Request $request)
    {


        $workHoliday = WorkHoliday::all();
        return response()->json($workHoliday);

    }

    public function workfromhome(Request $request)
    {


        $workFromHome = WorkFromHome::all();
        return response()->json($workFromHome);

    }

    public function store_leave(Request $request)
    {

        //dd($request->all());
        $id = $request->emp_id;
        $leave_type = $request->leave_type;
        $leave_desc = $request->leave_desc;
        $leave_many_day = $request->manyday;
        $leave_date_start = $request->dateStart;
        $leave_date_end = $request->dateEnd;


        $datetime1 = Carbon::parse($leave_date_start);
        $datetime2 = Carbon::parse($leave_date_end);
        $days = $datetime2->diffInDays($datetime1);
        $days = $days + 1;


//        $leave_status = $request->status;

        $leaveData = new LeaveData;
        $leaveData->user_id = $id;
        $leaveData->leave_type = $leave_type;
        $leaveData->leave_description = $leave_desc;
        $leaveData->start_date = $leave_date_start;
        $leaveData->manyday = $leave_many_day;
        $leaveData->days = $days;
        $leaveData->end_date = $leave_date_end;
//        $leaveData->leave_status = $leave_status;

        $leaveData->save();
        return response()->json($leaveData);


    }

    public function store_leave_edit(Request $request)
    {

        //dd($request->all());
        $record_id = $request->id;

        $leave_type = $request->leave_type;
        $leave_desc = $request->leave_description;
        $leave_many_day = $request->manyday;
        $leave_date_start = $request->start_date;
        $leave_date_end = $request->end_date;


        $datetime1 = Carbon::parse($leave_date_start);
        $datetime2 = Carbon::parse($leave_date_end);
        $days = $datetime2->diffInDays($datetime1);
        $days = $days + 1;


//        $leave_status = $request->status;

        $leaveData = LeaveData::where('id', '=', $record_id)->first();

        $leaveData->leave_type = $leave_type;
        $leaveData->leave_description = $leave_desc;
        $leaveData->start_date = $leave_date_start;
        $leaveData->manyday = $leave_many_day;
        $leaveData->days = $days;
        $leaveData->end_date = $leave_date_end;
//        $leaveData->leave_status = $leave_status;

        $leaveData->save();
        return response()->json($leaveData);


    }

    public function store_workfromhome(Request $request)
    {

        //dd($request->all());
        $id = $request->emp_id;
        $leave_type = $request->leave_type;
        $leave_desc = $request->leave_desc;
        $leave_date_start = $request->dateStart;
        $leave_date_end = $request->dateEnd;
        $leave_status = $request->status;

        $leaveData = new WorkFromHome();
        $leaveData->user_id = $id;
        $leaveData->leave_type = $leave_type;
        $leaveData->leave_desc = $leave_desc;
        $leaveData->start = $leave_date_start;
        $leaveData->end = $leave_date_end;
        $leaveData->leave_status = $leave_status;

        $leaveData->save();
        return response()->json($leaveData);


    }

    public function store_workholiday(Request $request)
    {

        //dd($request->all());
        $id = $request->emp_id;
        $leave_type = $request->leave_type;
        $leave_desc = $request->leave_desc;
        $leave_date_start = $request->dateStart;
        $leave_date_end = $request->dateEnd;
        $leave_status = $request->status;

        $leaveData = new WorkHoliday();
        $leaveData->user_id = $id;
        $leaveData->leave_type = $leave_type;
        $leaveData->leave_desc = $leave_desc;
        $leaveData->start = $leave_date_start;
        $leaveData->end = $leave_date_end;
        $leaveData->leave_status = $leave_status;

        $leaveData->save();
        return response()->json($leaveData);


    }

    public function store_in(Request $request)
    {
//        $aaa=[
//            'message' => ''
//        ];

        //$check_in_status = $request->checkInStatus;
        $employee_id = $request->employeeId;
        //$checkInTime = $request->createdAt;
        $thisTime = date('H:i:s');
        $thisTimeOnly = date('H:i:s');
        $thisDate = date('Y-m-d');

        $time = new Time;

        //where('start', thisDate);
        $check_status = Time::whereDate('start_date', '=', $thisDate)->where('user_id', '=', $employee_id)->get();
        //return response()->json($check_status);

        if ($check_status->isEmpty()) {

            if ($thisTimeOnly > '09:00:00') {
                //$time->check_in = $check_in_status;
                $time->user_id = $employee_id;
                $time->start_time = $thisTime;
                $time->start_date = $thisDate;
                $time->status = 'สาย';
                //$time->created_at = $checkInTime;
                $time->save();
            } else {
                //$time->check_in = $check_in_status;
                $time->user_id = $employee_id;
                $time->start_time = $thisTime;
                $time->start_date = $thisDate;
                $time->status = 'ปกติ';
                //$time->created_at = $checkInTime;
                $time->save();
            }


//            $time->check_in = $check_in_status;
//            $time->user_id = $employee_id;
//            $time->start_time = $thisTime;
//            //$time->created_at = $checkInTime;
//            $time->save();

            $response['message'] = 'Success';
            //$response['time'] = $time;
        } else {
            $response['message'] = 'Duplicate';
        }

        return response()->json($response);


    }

    public function store_out(Request $request, $id)
    {

        //$check_out_status = $request->checkOutStatus;
        $employee_id = $request->employeeId;
        $thisTime = date('H:i:s');
        $thisDate = date('Y-m-d');
        $time = Time::find($id);

        $check_status = Time::whereDate('end_date', '=', $thisDate)->where('user_id', '=', $employee_id)->get();
        $check_in = Time::whereDate('start_date', '=', $thisDate)->where('user_id', '=', $employee_id)->first();


//        $time->check_out = $check_Out_status;
//        $time->employee_id = $employee_id;
//        $time->end = $thisTime;
//
//
//        $time->save();
//dd($check_in);
        if (!empty($check_in)) {

            if ($check_status->isEmpty()) {
                //$time->check_out = $check_out_status;
                $time->user_id = $employee_id;
                $time->end_time = $thisTime;
                $time->end_date = $thisDate;
                //$time->created_at = $checkInTime;
                $time->save();

                $response['message'] = 'Success';
                //$response['time'] = $time;
            } else if ($check_status->isNotEmpty()) {
                $response['message'] = 'Duplicate';
            }
        } else if (empty($check_in)) {
            $response['message'] = 'NoCheckIn';
        }
        return response()->json($response);


    }

    public function checkuser(Request $request){
        $email = $request->email;

        $response['admin'] = users::where('email','=',$email)->first();
        return response()->json($response);
    }
}
