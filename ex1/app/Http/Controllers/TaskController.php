<?php
namespace App\Http\Controllers;

use App\Http\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    public function create(Request $request)
    {
        $task = new Task();
        $task->content = $request->input('content');
        $task->type = trim($request->input('type', ''));
        $task->done = false;
        $task->sort_order = Task::MAX_SORT_ORDER;

        if (!in_array($task->type, Task::types_names()))
            return response()->json([
                'message' => "The task type you provided is not supported. You can only use shopping or work.",
            ], 400);

        if (empty($task->content))
            return response()->json([
                'message' => "Bad move! Try removing the task instead of deleting its content.",
            ], 400);


        $task->date_created = Carbon::now();
        $task->save();

        return response()->json($task, 201)
            ->header('Location', route('api1.task.show', $task->uuid));
    }

    public function delete($id)
    {
        $task = Task::find($id);
        if ($task == null)
            return response()->json(
                ['message' => 'Good news! The task you were trying to delete didn\'t even exist.']
                , 404);
//            throw new NotFoundHttpException;
        $task->delete();

        return response()->json([], 204);
    }

    public function create_auto()
    {
        $task = new Task();
        $unique = date('Ymdis');
        $task->content = 'Content - ' . $unique;
        $task->type = Task::TYPE_WORK;
        $task->done = Task::STATUS_PENDING;
        $task->sort_order = Task::MAX_SORT_ORDER;
        $task->date_created = Carbon::now();
        $task->save();

        return response()->json($task, 201)
            ->header('Location', route('api1.task.show', $task->uuid));
    }

    /**
     * List task
     *
     * Filter status=pending|status=complete
     *
     * @return JsonResponse
     */
    public function index()
    {
        $done = Input::get('done');
        $tasks_query = Task::query();

        if ($done == 'true')
            $tasks_query->where('done', true);
        elseif ($done == 'false')
            $tasks_query->where('done', false);

        $tasks_query->select('uuid', 'content', 'sort_order');

        $tasks_query->orderBy('sort_order', 'ASC');
        $tasks = $tasks_query->get();

        if ($tasks->isEmpty())
            return response()->json(['message' => 'Wow. You have nothing else to do. Enjoy the rest of your day!'], 200);

        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if ($task == null)
            throw new NotFoundHttpException;

        return response()->json($task);
    }

    /**
     * Turn task complete
     * @param $id
     * @return JsonResponse
     */
    public function done($id)
    {
        /** @var Task|Collection $task */
        $task = Task::find($id);
        if ($task == null) {
            throw new NotFoundHttpException;
        }
        $task->done = true;
        $task->save();
    }


    /**
     * Update task
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        /** @var Task|Collection $task */
        $task = Task::find($id);
        if ($task == null) {
            return response()->json([
                'message' => 'Are you a hacker or something? The task you were trying to edit doesn\'t exist.'
            ], 404);
//            throw new NotFoundHttpException;
        }
        $task->content = $request->input('content');
        $task->type = trim($request->input('type', ''));

        if (!in_array($task->type, Task::types_names()))
            return response()->json([
                'message' => "The task type you provided is not supported. You can only use shopping or work.",
            ], 400);

        if (empty($task->content))
            return response()->json([
                'message' => "Bad move! Try removing the task instead of deleting its content.",
            ], 400);

        $task->save();
        return response()->json([], 204);
    }

    public function priority($id, $sort_order = 1)
    {
        if (!is_numeric($sort_order))
            return response()->json(['message' => 'param is not a number'], 500);

        /** @var Task $task */
        $task = Task::find($id);
        if ($task->sort_order == $sort_order) //sort_order actual
            return;

        $task_query = Task::query();
        $tasks = $task_query
            ->where('sort_order', '>=', $sort_order)
            ->where('uuid', '!=', $id)
            ->orderBy('sort_order', 'ASC')
            ->select('uuid', 'sort_order')
            ->get();

        $task->sort_order = $sort_order;
        $task->save();

        //update all
        foreach ($tasks as $t) {
            $sort_order += 1;
            /** @var Task $t */
            $t->sort_order = $sort_order;
            //but save if sort_order actual different than this saved in the db
            $t->save();
        }
    }

}