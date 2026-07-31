<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Services\LeaveService;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{   

    protected $employeeService;
    protected $leaveService;
    public function __construct(
        EmployeeService $employeeService,
        LeaveService $leaveService
    )
    {   
        $this->employeeService = $employeeService;
        $this->leaveService = $leaveService;
    }

    public function aiContext(Request $request)
    {
        try
        {
            $leave = $this->leaveService->index($request)->where('id',$request->leave_id)->first();

            if($leave->check_ai_review)
            {
                return response()->json(['status'=>true, 'data'=>$leave->aiReview]);
            }    

            $employee = $this->employeeService->index($request)->where('id',$leave->employee_id)->first();
            //return $employee;
            $employeeContext = $this->employeeService->context($employee->id,$leave);

            //return response()->json(['status'=>true, 'data'=>$context]);


            $prompt = "
                You are an experienced HR Manager and AI Leave Review Assistant.

                Analyze the employee leave request based on the provided employee data.

                Rules:

                1. Check available leave balance.
                2. Check previous leave history and patterns.
                3. Check current leave request details.
                4. Identify unusual or excessive leave behavior.
                5. Provide a fair HR recommendation.

                Return ONLY valid JSON.

                Response format:

                {
                    \"recommendation\": \"positive|negative|neutral\",
                    \"confidence\": 0,
                    \"ai_review\": \"short professional explanation\"
                }

                Employee Data:

                " . json_encode($employeeContext, JSON_PRETTY_PRINT);



                $response = Http::withToken(env('OPENAI_API_KEY'))
                    ->post('https://api.openai.com/v1/responses', [

                        "model" => "gpt-5.5",

                        "input" => $prompt,

                        "text" => [
                            "format" => [
                                "type" => "json_object"
                            ]
                        ]

                    ]);



                if (!$response->successful()) {

                    return response()->json([
                        "status" => false,
                        "message" => "AI review failed",
                        "data" => $response->json()
                    ], 500);

                }



                $data = $response->json();

                $text = $data['output'][1]['content'][0]['text'] ?? null;


                if (!$text) {

                    return response()->json([
                        "status" => false,
                        "message" => "Invalid AI response"
                    ],500);

                }


                $result = json_decode($text, true);

                $data = array(
                    'leave_id' => $leave->id,
                    'type' => $result['recommendation'],
                    'ai_review' => $result['ai_review'],
                );

                $this->leaveService->saveAiReview($data);

                return response()->json(['status'=>true, 'data'=>$data]);


                return response()->json([

                    "status" => true,

                    "recommendation" => $result['recommendation'] ?? null,

                    "confidence" => $result['confidence'] ?? 0,

                    "ai_review" => $result['ai_review'] ?? null

                ]);


        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
