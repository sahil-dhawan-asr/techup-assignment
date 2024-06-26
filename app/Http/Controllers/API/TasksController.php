<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\TaskAndNotesRequest;
use Exception;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /** Creating Task and saving notes data */
    public function saveTasksAndNotes(TaskAndNotesRequest $request){
        try {
            $task = Task::create($request->only('subject',
                        'description',
                        'start_date',
                        'due_date',
                        'status',
                        'priority'));
            foreach ($request->notes as  $noteData) {
                $note = $task->notes()->create([
                    'subject' => $noteData['subject'],
                    'note' => $noteData['note'],
                ]);
                if (isset($noteData['attachments'])) {
                    foreach ($noteData['attachments'] as $attachment) {
                        $path = $attachment->store('attachments');
                        $note->attachments()->create(['file_path' => $path]);
                    }
                }
            }
            return response()->json([
                'message' => trans("messages.task_notes_success"),
            ],Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getTasks(Request $request){

        $tasks = Task::whereHas("notes")->with('notes.attachments')
            ->when($request->filter, function ($query) use ($request) {
                if (isset($request->filter['status'])) {
                    $query->where('status', $request->filter['status']);
                }
                if (isset($request->filter['due_date'])) {
                    $query->where('due_date', '<=', $request->filter['due_date']);
                }
                if (isset($request->filter['priority'])) {
                    $query->where('priority', $request->filter['priority']);
                }
            })
            ->withCount("notes")
            ->orderByRaw("FIELD(priority, 'High', 'Medium', 'Low')")
            ->orderBy("notes_count")
            ->get();

            $data = $tasks->count() > 0 ? $tasks : [];
            return response()->json([
                'message' => trans("messages.task_notes_retrieved"),
                'data'=>$data
            ],Response::HTTP_OK);
    }
}
