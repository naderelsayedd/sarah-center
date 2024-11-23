<?php 
namespace App\Http\Controllers\Admin\InterviewParent;

use Illuminate\Http\Request;
use App\Models\InterviewSchedule;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ParentInterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interviews = InterviewSchedule::with('user')->orderBy('id','DESC')->get();
        return view('backEnd.parentInterview.index', compact('interviews'));
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
        $interview = InterviewSchedule::find($id);
        $interview->admin_comment = $request['admin_comment'];
        $interview->status = $request['status'];
        $interview->save();
        Toastr::success('Interview updated successfully!','Success');
        return redirect()->route('interviews.parent.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $interview = InterviewSchedule::find($id);
        $interview->delete();
        Toastr::success('Interview deleted successfully!','Success');
        return redirect()->route('interviews.parent.index');
    }
}