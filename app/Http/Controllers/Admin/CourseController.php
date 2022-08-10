<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CourseAccessType;
use App\Enums\CourseLevel;
use App\Enums\CourseType;
use App\Enums\VideoType;
use App\Enums\ZoomMeetingType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddCourseRequest;
use App\Models\Artist;
use App\Models\Course;
use App\Models\Dance;
use App\Models\LiveCourse;
use DateTime;
use Illuminate\Http\Request;
use MacsiDigital\Zoom\Facades\Zoom;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::whereDoesntHave('live')->get();

        $langs = $this->lang;

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "courses"],
        ];

        $addNewBtn = "admin.course.create";

        $pageConfigs = ['pageHeader' => true];

        return view('backend.courses.list', compact('courses', 'langs', 'pageConfigs', 'breadcrumbs', 'addNewBtn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langs = $this->lang;

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/course", 'name' => "Courses"], ['name' => "Create"]
        ];

        $pageConfigs = ['pageHeader' => true];

        $dances = Dance::all()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->translateOrDefault()->name];
            });

        $artists = Artist::all()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->profile->fullName];
            });

        $videoTypes = VideoType::asSelectArray();
        $courseAccessTypes = CourseAccessType::asSelectArray();
        $courseLevels = CourseLevel::asSelectArray();
        $courseTypes = CourseType::asSelectArray();

        return view('backend.courses.add', compact('langs', 'breadcrumbs', 'pageConfigs', 'dances', 'artists', 'videoTypes', 'courseAccessTypes', 'courseLevels', 'courseTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCourseRequest $request)
    {
        try {
            $course = new Course();
            $course->dance_id = $request->dance;
            $course->artist_id = $request->artist;
            $course->price = $request->price;
            $course->promo_video = $request->promo_video;
            $course->video = $request->video;
            $course->duration = $request->duration;
            $course->course_level = intval($request->courseLevel);
            $course->video_type =  intval($request->videoType);

            if ($request->start_at) {
                $date = DateTime::createFromFormat('Y-m-d\TH:i', $request->start_at);
                $course->start_at = $date->format('Y-m-d H:i:s');
            }

            if ($request->expire_at) {
                $date = DateTime::createFromFormat('Y-m-d\TH:i', $request->expire_at);
                $course->expire_at = $date->format('Y-m-d H:i:s');
            }

            $course->is_published = ($request->has('is_published')) ? true : false;

            $courseGallery = [];
            $courseImage = [];

            if ($request->hasfile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $image = uploadFile('course', $file);
                    $courseGallery[] = saveFileUploaderMedia($image, $file, 'course');
                }
            }

            if ($request->file('image')) {
                $image = uploadFile('course', $request->file('image'));
                $courseImage[] = saveFileUploaderMedia($image, $request->file('image'), 'course');
            }

            $course->gallery = count($courseGallery) ? json_encode($courseGallery) : null;
            $course->image = json_encode($courseImage);
            $course->save();

            if (!empty($course)) {
                foreach ($this->lang as $lang) {
                    $course->translateOrNew($lang['code'])->title = trim($request->get('title_' . $lang['code']));
                    $course->translateOrNew($lang['code'])->description = trim($request->get('description_' . $lang['code']));
                    $course->save();
                }
            }

            return redirect(route('admin.course.show', $course->id))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $langs = $this->lang;

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/courses", 'name' => "Courses"], ['name' => "Update"]
        ];

        $pageConfigs = ['pageHeader' => true];

        $dances = Dance::all()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->translateOrDefault()->name];
            });

        $artists = Artist::all()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->profile->fullName];
            });

        $videoTypes = VideoType::asSelectArray();
        $courseAccessTypes = CourseAccessType::asSelectArray();
        $courseLevels = CourseLevel::asSelectArray();
        $courseTypes = CourseType::asSelectArray();

        return view('backend.courses.show', compact(['course', 'langs', 'breadcrumbs', 'pageConfigs', 'dances', 'artists', 'videoTypes', 'courseAccessTypes', 'courseLevels', 'courseTypes']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(AddCourseRequest $request, Course $course)
    {
        try {
            $course->dance_id = $request->dance;
            $course->artist_id = $request->artist;
            $course->price = $request->price;
            $course->promo_video = $request->promo_video;
            $course->video = $request->video;
            $course->duration = $request->duration;
            $course->course_level = intval($request->courseLevel);
            $course->video_type =  intval($request->videoType);

            if ($request->start_at) {
                $date = DateTime::createFromFormat('Y-m-d\TH:i', $request->start_at);
                $course->start_at = $date->format('Y-m-d H:i:s');
            }

            if ($request->expire_at) {
                $date = DateTime::createFromFormat('Y-m-d\TH:i', $request->expire_at);
                $course->expire_at = $date->format('Y-m-d H:i:s');
            }

            $course->is_published = ($request->has('is_published')) ? true : false;


            $courseImage = [];

            if ($request->file('image')) {
                $oldImage = $course->getCourseImage();
                $image = uploadFile('course', $request->file('image'), $oldImage);
                $courseImage[] = saveFileUploaderMedia($image, $request->file('image'), 'course');

                $course->image = json_encode($courseImage);
            }

            $current_images = getCurrentFileUploaderMedia($request->get('fileuploader-list-gallery'));

            $updated_images = getUpdatedFileUploaderMedia($course->gallery, $current_images);

            if ($request->hasfile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $image = uploadFile('course', $file);
                    $updated_images[] = saveFileUploaderMedia($image, $file, 'course');
                }
            }

            $course->gallery = json_encode($updated_images);

            $course->save();
            return redirect(route('admin.course.show', $course->id))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect(route('admin.course.index'))->with('success', __('system-messages.delete'));
    }

    public function listLiveCourses()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "artist/courses", 'name' => "Courses"], ['name' => "live"]
        ];

        $pageConfigs = ['pageHeader' => true];

        $courses =  Course::whereHas('live')->get();

        return view('backend.courses.live.list', compact(['courses', 'breadcrumbs', 'pageConfigs']));
    }

    public function storeLiveCourse(Course $course)
    {
        try {
            $user = Zoom::user()->get()->first();

            $meetingData = [
                'topic' => $course->translateOrDefault()->title,
                'type' => ZoomMeetingType::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($course->start_at),
                'duration' => $course->duration,
                'agenda' => $course->translateOrDefault()->description,
                'password' => '12345678',
                'timezone' => 'Asia/Amman',
            ];

            $meeting = Zoom::meeting()->make($meetingData);

            $meeting = $user->meetings()->save($meeting);

            $meeting->settings()->make([
                'join_before_host' => false,
                'host_video' => false,
                'participant_video' => false,
                'mute_upon_entry' => false,
                'waiting_room' => false,
                'auto_recording' => "local",
            ]);

            $meeting = $user->meetings()->save($meeting);

            $liveCourse = new LiveCourse();
            $liveCourse->course_id = $course->id;
            $liveCourse->meeting_id = $meeting->id;
            $liveCourse->topic = $course->translateOrDefault()->title;
            $liveCourse->description = $course->translateOrDefault()->description;
            $liveCourse->start_at = $course->start_at;
            $liveCourse->duration = $course->duration;
            $liveCourse->password = $meeting->password;
            $liveCourse->start_url = $meeting->start_url;
            $liveCourse->join_url = $meeting->join_url;
            $liveCourse->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showLiveCourse(LiveCourse $liveCourse)
    {
        try {
            $artist = $liveCourse->course->artist;

            $breadcrumbs = [
                ['link' => "admin", 'name' => "Dashboard"], ['link' => "artist/liveCourse", 'name' => "Live Courses"], ['name' => "Update"]
            ];

            $pageConfigs = ['pageHeader' => true];

            return view('backend.courses.live.show', compact(['liveCourse', 'artist', 'breadcrumbs', 'pageConfigs']));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateLiveCourse(Request $request, liveCourse $liveCourse)
    {
        try {
            $nonFormattedStartAt = DateTime::createFromFormat('Y-m-d\TH:i', $request->start_at);
            $startAt = $nonFormattedStartAt->format('Y-m-d H:i:s');

            $meetingData = [
                'topic' => $request->title,
                'type' => ZoomMeetingType::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($startAt),
                'duration' => $request->duration,
                'agenda' => $request->description,
                'password' => $request->password,
                'timezone' => 'Asia/Amman',
            ];

            $user = Zoom::user()->get()->first();
            $meeting = Zoom::meeting()->find($liveCourse->meeting_id);
            $meeting->update($meetingData);
            $meeting->settings()->make([
                'join_before_host' => false,
                'host_video' => false,
                'participant_video' => ($request->has('participant_video')) ? true : false,
                'mute_upon_entry' => ($request->has('mute_upon_entry')) ? true : false,
                'waiting_room' => false,
                'auto_recording' => "local",
            ]);

            $meeting = $user->meetings()->save($meeting);

            $liveCourse->topic = $request->topic;
            $liveCourse->description = $request->description;
            $liveCourse->duration = $request->duration;
            $liveCourse->password = $meeting->password;
            $liveCourse->start_url = $meeting->start_url;
            $liveCourse->join_url = $meeting->join_url;
            $liveCourse->start_at = $startAt;
            $liveCourse->participant_video = ($request->has('participant_video')) ? true : false;
            $liveCourse->mute_upon_entry = ($request->has('mute_upon_entry')) ? true : false;
            $liveCourse->save();

            return redirect(route('artist.course.live.show', $liveCourse))->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteLiveCourse(liveCourse $liveCourse)
    {
        try {
            $course = $liveCourse->course;
            $meeting = Zoom::meeting()->find($liveCourse->meeting_id);
            $meeting->delete();
            $liveCourse->delete();
            return redirect(route('admin.course.show', $course))->with('success', __('system-messages.delete'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
