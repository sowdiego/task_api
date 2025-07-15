<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Task API",
 *     version="1.0.0",
 *     description="API de gestion des tâches"
 * )
 *
 * @OA\Tag(
 *     name="Tâches",
 *     description="Endpoints liés aux tâches"
 * )
 */
class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Liste des tâches",
     *     tags={"Tâches"},
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Task"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Task::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks-paginated",
     *     summary="Liste paginée des tâches",
     *     tags={"Tâches"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Numéro de page",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Nombre d'éléments par page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste paginée",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="total", type="integer", example=45),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Task")
     *             )
     *         )
     *     )
     * )
     */
    public function paginated(Request $request)
    {
        $perPage = $request->get('per_page', 10); // par défaut 10
        $tasks = Task::paginate($perPage);
        return response()->json($tasks);
    }


    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Créer une tâche",
     *     tags={"Tâches"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", example="Faire les courses"),
     *             @OA\Property(property="description", type="string", example="Acheter du lait et du pain"),
     *             @OA\Property(property="is_done", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tâche créée",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_done' => 'boolean',
        ]);

        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Afficher une tâche",
     *     tags={"Tâches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la tâche",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tâche trouvée",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=404, description="Tâche non trouvée")
     * )
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }
        return response()->json($task);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Mettre à jour une tâche",
     *     tags={"Tâches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la tâche",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Nouvelle tâche"),
     *             @OA\Property(property="description", type="string", example="Description mise à jour"),
     *             @OA\Property(property="is_done", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tâche mise à jour",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=404, description="Tâche non trouvée")
     * )
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'is_done' => 'boolean',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Supprimer une tâche",
     *     tags={"Tâches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la tâche",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tâche supprimée",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Tâche supprimée avec succès")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Tâche non trouvée")
     * )
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Tâche supprimée avec succès']);
    }
}
