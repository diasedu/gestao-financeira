<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected Finance $financeModel;
    
    public function __construct()
    {
        $this->financeModel = new Finance();
    }

    private const VALIDATION_RULES = [
        'descricao' => ['required', 'max:255'],
        'valor'     => ['required', 'decimal:2']
    ];
        
    public function save(Request $request): JsonResponse
    {
        try {
            $data      = $request->all();
            $validator = validator($data, self::VALIDATION_RULES);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'data'   => $validator->errors(),
                ], 422);
            }

            $this->financeModel->desc  = $data['descricao'];
            $this->financeModel->value = $data['valor'];
            $this->financeModel->save();

            $id = $this->financeModel->id;

            return response()->json([
                'status'  => 'success',
                'message' => 'Recurso criado com sucesso!',
                'data'    => ['id' => $id]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Ops... Tivemos um imprevisto mas não se preocupe! Nossa equipe já está avaliando o ocorrido. Tente novamente mais tarde.'
            ], 500);
        }
    }

    public function get(int $id): JsonResponse
    {
        try {
            if ($id <= 0) {
                return response()->json([
                    'status'  => 'warning',
                    'message' => 'Informe um id válido.',
                ], 422);
            }

            $finance = $this->financeModel::find($id);
            
            if (!$finance) {
                return response()->json([
                    'status'  => 'warning',
                    'message' => 'Informe um id válido e existente.'
                ], 422);
            }

            return response()->json([
                'status' => 'success',
                'data'   => $finance
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Ops... Tivemos um imprevisto mas não se preocupe! Nossa equipe já está avaliando o ocorrido. Tente novamente mais tarde.'
            ], 500);
        }
    }

    public function list(): JsonResponse
    {
        try {
            $finances = $this->financeModel::all();

            return response()->json([
                'status' => 'success',
                'data'   => $finances
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Ops... Tivemos um imprevisto mas não se preocupe! Nossa equipe já está avaliando o ocorrido. Tente novamente mais tarde.'
            ], 500);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            if ($id <= 0) {
                return response()->json([
                    'status'  => 'warning',
                    'message' => 'Informe um id válido.',
                ], 422);
            }

            $finance = $this->financeModel::find($id);
            
            if (!$finance) {
                return response()->json([
                    'status'  => 'warning',
                    'message' => 'Informe um id válido e existente.'
                ], 422);
            }

            $finance->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Deletado com sucesso!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Infelizmente tivemos um problema com a sua solicitação mas não se preocupe! A nossa equipe técnica estará verificando :)'
            ], 500);
        }
        
    }
}
