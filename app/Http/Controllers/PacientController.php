<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Address;
use App\Models\Pacient;
use App\Traits\CNSValidation;
use App\Traits\UploadLocalFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacientController extends Controller
{
    use UploadLocalFiles;
    use CNSValidation;

    public function index(Request $request)
    {
        $search = $request->query('search');

        $pacients = Pacient::with('address')
            ->whereRaw('lower(cpf) LIKE ?', ["%".strtolower($search)."%"])
            ->orWhereRaw('lower(full_name) LIKE ?', ["%".strtolower($search)."%"])
            ->paginate(10);

        if ($pacients->isEmpty()) {
            return response()->json(['message' => 'Nenhum registro encontrado.'], 404);
        }

        $pacients->transform(function ($pacient) {
            if ($pacient->photo) {
                $pacient->photo = $_ENV['APP_URL'] . '/storage/photos/' . $pacient->photo;
            }

            return $pacient;
        });

        return $pacients;
    }

    public function show($id)
    {
        $pacient = Pacient::with('address')->find($id);

        if (!$pacient)
            return response()->json(['message' => 'Registro não encontrado.'], 404);

        return $pacient;
    }

    public function store(Request $request)
    {
        $addressValidated = Validator::make($request->all(), [
            'zip_code' => 'required',
            'street' => 'required|max:255',
            'number' => 'required|integer',
            'district' => 'required|max:100',
            'city' => 'required|max:100',
            'state' => 'required|max:2',
        ]);

        if ($addressValidated->fails()) {
            return response()->json([
                "error" => 'validation_error',
                "message" => $addressValidated->errors(),
            ], 422);
        }

        $address = Address::create($request->all());
        if (!$address)
            return response()->json(['message' => 'Erro ao salvar endereço.', 500]);

        $pacientValidated = Validator::make($request->all(), [
            'full_name' => 'required|max:255',
            'mother_full_name' => 'required|max:255',
            'birth_day' => 'required',
            'cpf' => 'required',
            'cns' => 'required|integer'
        ]);

        if ($pacientValidated->fails()) {
            return response()->json([
                "error" => 'validation_error',
                "message" => $pacientValidated->errors(),
            ], 422);
        }

        // Validate CNS
        if (in_array($request->cns[0], ['1', '2'])) {
            $cnsValidation = $this->numbersStartedWithOneOrTwo($request->cns);

            if (!$cnsValidation) {
                return response()->json(['message' => 'O número CNS informado é inválido.'], 400);
            }
        } else {
            $cnsValidation = $this->numbersStartedWithSevenEightOrNine($request->cns);

            if (!$cnsValidation) {
                return response()->json(['message' => 'O número CNS informado é inválido.'], 400);
            }
        }

        // Validate CPF
        if (!Helpers::validateCPF($request->cpf)) {
            return response()->json(['message' => 'O número CPF informado é inválido.'], 400);
        }

        // Image upload
        $namePhotoFile = '';
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $upload = $this->uploadPacientPhoto($request, 'photo');

            if (!$upload['ok']) {
                return response()->json(['message' => $upload['message']]);
            }

            $namePhotoFile = $upload['filename'];
        }

        $pacient = Pacient::create(array_merge($request->all(), [
            'address_id' => $address->id,
            'photo' => $namePhotoFile
        ]));
        if (!$pacient)
            return response()->json(['message' => 'Erro ao salvar paciente.', 500]);

        return response()->json(['message' => 'Registro salvo com sucesso.']);
    }

    public function update(Request $request, $id)
    {
        if (Pacient::where('id', $id)->exists()) {
            $pacient = Pacient::find($id);
            $address = Address::find($pacient->address_id);

            $namePhotoFile = $pacient->photo;

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $upload = $this->uploadPacientPhoto($request, 'photo');

                if (!$upload['ok']) {
                    return response()->json(['message' => $upload['message']]);
                }

                $namePhotoFile = $upload['filename'];
            }

            $pacient->full_name = $request->full_name;
            $pacient->mother_full_name = $request->mother_full_name;
            $pacient->birth_day = $request->birth_day;
            $pacient->photo = $namePhotoFile;
            $pacient->save();

            $address->street = $request->street;
            $address->number = $request->number;
            $address->complement = $request->complement;
            $address->district = $request->district;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->zip_code = $request->zip_code;
            $address->save();

            return response()->json(['message' => 'Registro atualizado com sucesso.']);
        }

        return response()->json(['message' => 'Registro não localizado.'], 404);
    }

    public function destroy($id)
    {
        $pacient = Pacient::find($id);
        if (!$pacient)
            return response()->json(['message' => 'Registro não encontrado.'], 404);


        $address = Address::find($pacient->address_id);

        $pacient->delete();
        $address->delete();

        return response()->json(['message' => 'Registro removido com sucesso.']);
    }
}
