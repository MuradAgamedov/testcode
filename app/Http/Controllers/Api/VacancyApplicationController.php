<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use App\Models\VacancyApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacancyApplicationController extends Controller
{
    // HR-nın vakansiyalarına müraciət etmiş istifadəçiləri göstərmək üçün metod
    public function getVacancyApplications(Request $request)
    {
        // HR istifadəçisinin autentifikasiya edilmiş məlumatlarını əldə edirik
        $hrUser = auth()->user();

        // HR istifadəçisinin yaratdığı vakansiyaları əldə edirik
        $vacancies = Vacancy::where('user_id', $hrUser->id)->get();

        // HR-nın vakansiyalarına müraciət edən bütün istifadəçiləri tapırıq
        $applications = VacancyApplication::with('user', 'vacancy')
            ->whereIn('vacancy_id', $vacancies->pluck('id')->toArray()) // HR-nın öz vakansiyalarına müraciət edənləri seçirik
            ->get();

        // Müraciətləri JSON formatında qaytarırıq
        return response()->json($applications);
    }

    // Yeni müraciət yaratmaq üçün metod
    public function store(Request $request)
    {
        $data = $request->validate([
            'vacancy_id' => 'required|exists:vacancies,id',
        ]);

        // Müraciəti göndərən işçi istifadəçisinin ID-sini əlavə edirik
        $data['user_id'] = auth('worker')->id();

        // 'pending' statusunun ID-sini alırıq
        $pendingStatusId = \App\Models\ApplicationStatus::where('name', 'pending')->value('id');

        if (!$pendingStatusId) {
            return response()->json(['message' => 'Pending status not found'], 500);
        }

        $data['application_status_id'] = $pendingStatusId;

        // Yeni müraciəti yaradıq
        $application = VacancyApplication::create($data);

        // Yeni yaradılmış müraciəti qaytarırıq
        return response()->json($application, 201);
    }

    // Müraciəti göstərmək üçün metod
    public function show($id)
    {
        $application = VacancyApplication::with(['user', 'vacancy'])->findOrFail($id);
        return response()->json($application);
    }

    // Müraciətin statusunu yeniləmək üçün metod
public function update(Request $request, $id)
{
    auth()->shouldUse('hr');

    $request->validate([
        'application_status_id' => 'required|exists:application_statuses,id',
    ]);

    $application = VacancyApplication::with('vacancy')->findOrFail($id);
    // dd($application);
    // Yalnız HR istifadəçisi öz müraciətlərini yeniləyə bilər
    if (!$application) {
        return response()->json(['message' => 'Application not found'], 404);
    }
//    if ($application->vacancy->user_id !== auth('hr')->id()) {
//        return response()->json(['message' => 'Unauthorized'], 403);
//    }
    $application->application_status_id = $request->application_status_id;
    $application->save();


    return response()->json([
        'message' => 'Application updated successfully',
        'data' => $application
    ]);
}




    // Statusu yeniləyirik


    // Müraciəti silmək üçün metod
    public function destroy($id)
    {
        $application = VacancyApplication::findOrFail($id);
        $application->delete();

        return response()->json(['message' => 'Deleted']);
    }

    // HR istifadəçisinin müraciət statusunu yeniləmək üçün metod
    public function updateUserApplicationStatus(Request $request, $userId, $vacancyId)
    {
        $request->validate([
            'status_id' => 'required|exists:application_statuses,id',
        ]);

        $application = VacancyApplication::where('user_id', $userId)
            ->where('vacancy_id', $vacancyId)
            ->firstOrFail();

        // Yalnız HR istifadəçisi öz müraciətlərini yeniləyə bilər
        if ($application->vacancy->user_id !== auth('hr')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $application->application_status_id = $request->status_id;
        $application->save();

        return response()->json([
            'message' => 'Application status updated successfully',
            'data' => $application
        ]);
    }
}
