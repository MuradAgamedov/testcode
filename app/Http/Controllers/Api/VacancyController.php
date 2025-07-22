<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Vacancy;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::with(['user', 'company', 'role', 'skills'])->get();

        $vacancies = $vacancies->map(function ($vacancy) {
            return [
                'id' => $vacancy->id,
                'title' => $vacancy->title,
                'description' => $vacancy->description,
                'user' => $vacancy->user,
                'company' => $vacancy->company,
                'role' => $vacancy->role,
                'skills' => json_decode($vacancy->skills, true),
                'experience_year' => $vacancy->experience_year,
                'technical_task_file' => $vacancy->technical_task_file 
                    ? url('storage/' . $vacancy->technical_task_file)
                    : null,
            ];
        });

        return response()->json($vacancies);
    }

public function indexForWorker()
{
    $vacancies = Vacancy::with(['company', 'role', 'skills'])->latest()->get();


$vacancies = $vacancies->map(function ($vacancy) {

    return [
        'id' => $vacancy->id,
        'title' => $vacancy->title,
        'description' => $vacancy->description,
        'company' => $vacancy->company,
        'role' => $vacancy->role,
        'skills' =>  json_decode($vacancy->skills, true),
        'experience_year' => $vacancy->experience_year,
        'technical_task_file' => $vacancy->technical_task_file 
            ? url('storage/' . $vacancy->technical_task_file)
            : null,
    ];
});

    return response()->json($vacancies);
}




  public function store(Request $request)
{
    // 1. Validation
    $validator = FacadesValidator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'is_internship' => 'nullable|in:0,1',
        'company_id' => 'required',
        'shared_at' => 'required',
        'stage_type' => 'nullable',
        'deadline' => 'nullable|date',
        'vacancy_type' => 'nullable|string|max:255',
        'technical_task_time' => 'nullable|string|max:255',
        'skill_ids' => 'nullable|array',
        'skill_ids.*' => 'exists:skills,id',
        'technical_task_file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        'experience_year' => 'required|integer|min:1|max:5',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422);
    }

    $data = $validator->validated();

    // 2. Əlavə dəyər
    $data['user_id'] = 1;

    // 3. Fayl varsa, yadda saxla
    if ($request->hasFile('technical_task_file')) {
        $filePath = $request->file('technical_task_file')->store('technical-tasks', 'public');
        $data['technical_task_path'] = $filePath;
    }

    // 4. Vacancy yarat
    $vacancy = Vacancy::create($data);

    // 5. Skill attach və relation yüklə
    if (!empty($data['skill_ids'])) {
        $vacancy->skills()->attach($data['skill_ids']);
    }
    $vacancy->load('skills'); // eyni modeldən istifadə, əlavə sorğu atmır
    // 6. JSON cavab
    return response()->json([
        'message' => 'Vacancy created successfully.',
        'data' => [
            'id' => $vacancy->id,
            'title' => $vacancy->title,
            'description' => $vacancy->description,
            'skills' => $vacancy->skills()->pluck('name')->toArray(),
        ],
    ], 201);
}

    public function update(Request $request, Vacancy $vacancy)
{
    $data = $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'is_internship' => 'nullable|in:0,1',
        'deadline' => 'nullable|date',
        'vacancy_type' => 'nullable|string|max:255',
        'technical_task_time' => 'nullable|string|max:255',
        'skill_ids' => 'nullable|array',
        'skill_ids.*' => 'exists:skills,id',
        'technical_task_file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        'experience_year' => 'sometimes|integer|min:1|max:5',

    ]);

    if ($request->hasFile('technical_task_file')) {
        $filePath = $request->file('technical_task_file')->store('technical-tasks', 'public');
        $data['technical_task_path'] = $filePath;
    }

    $vacancy->update($data);

    if (!empty($data['skill_ids'])) {
        $vacancy->skills()->sync($data['skill_ids']);
    }
//     dd([
//     'validated_data' => $data,
//     'before_update' => $vacancy->only(array_keys($data)),
// ]);

    return response()->json([
        'message' => 'Vacancy updated successfully.',
        'data' => [
        'id' => $vacancy->id,
        'title' => $vacancy->title,
        'description' => $vacancy->description,
        'skills' =>  json_decode($vacancy->skills, true),
        ]

    ]);
}


public function show($id)
{
    $user = auth('hr')->user() ?? auth('worker')->user();

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $vacancy = Vacancy::with(['company', 'skills'])->findOrFail($id);

    return response()->json([
        'vacancy' => [
            'id' => $vacancy->id,
            'title' => $vacancy->title,
            'description' => $vacancy->description,
            'experience_year' => $vacancy->experience_year,
            'experience_year_text' => $vacancy->experience_year == 5 ? '5+ il' : $vacancy->experience_year . ' il',
            'technical_task_file' => $vacancy->technical_task_file 
                ? url('storage/' . $vacancy->technical_task_file)
                : null,
            'skills' => $vacancy->skills,
            'company' => $vacancy->company ? [
                'id' => $vacancy->company->id,
                'name' => $vacancy->company->name,
            ] : null,
        ],
        'is_wishlisted' => $user->wishlistedVacancies()->where('vacancy_id', $vacancy->id)->exists(), // Bu metod artıq `User` modelində olmalıdır.
        'viewer_role' => auth('hr')->check() ? 'hr' : 'worker'
    ]);
}






    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // app/Http/Controllers/Api/VacancyController.php

    public function internVacancies()
    {
        $category = Category::where('name','intern')->first();
        $vacancies = Vacancy::with(['company', 'role', ])
            ->where('category_id', $category->id)
            ->get();

        return response()->json($vacancies);
    }


    public function matchedVacancies(Request $request)
    {
        $user = auth()->user();

        $userSkillIds = $user->skills()->pluck('skills.id');

        $vacancyIds = DB::table('skill_job')
            ->whereIn('skill_id', $userSkillIds)
            ->pluck('vacancy_id');

        if ($vacancyIds->isEmpty()) {
            return response()->json([
                'message' => 'No matching vacancies found',
                'data' => [],
            ], 200);
        }

        $vacancies = Vacancy::whereIn('id', $vacancyIds)
            ->with(['company', 'role', ]) // relationlar varsa
            ->get();

        return response()->json([
            'message' => 'Matching vacancies',
            'data' => $vacancies,
        ]);
    }
    public function showApplications($vacancyId)
    {
        // Vakansiyanın məlumatlarını alırıq
        $vacancy = Vacancy::findOrFail($vacancyId);

        // Müraciətləri gətiririk
        $applications = $vacancy->applicants;

        return view('vacancy.applications', compact('applications'));
    }
    // app/Http/Controllers/Api/VacancyController.php

    public function incrementView($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->increment('views');

        return response()->json([
            'message' => 'View incremented',
            'views' => $vacancy->views
        ]);
    }

    public function applicantsCount(Vacancy $vacancy)
    {
        $count = $vacancy->applicants()->count();

        return response()->json([
            'vacancy_id' => $vacancy->id,
            'title' => $vacancy->title,
            'applicants_count' => $count
        ]);
    }


}
