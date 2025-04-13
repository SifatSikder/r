<?php

namespace App\Repositories\Admin;

use App\Models\EvaluationSectors;
use App\Models\FairDecisionSectors;
use App\Models\QuestionGroups;
use App\Models\RiskFactors;
use App\Models\WebsiteSettings;
use Illuminate\Support\Facades\Validator;

class EvaluationSectorsRepository
{
    /**
     * Retrieve evaluation sectors based on the provided criteria.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status', 'data', or 'error' keys.
     */
    public static function GetAll($request)
    {
        try {
            // Validate input parameters
            $input = $request->input();
            $validator = Validator::make($input, [
                'keyword' => 'nullable',
            ]);
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Retrieve evaluation sectors based on the provided criteria
            $sectors = EvaluationSectors::where(function ($q) use ($request) {
                if (!empty($request->keyword)) {
                    $q->where('title', 'LIKE', '%' . $request->keyword . '%');
                }
                if (!empty($request->parent_id)) {
                    $q->where('parent_id', (int)$request->parent_id);
                } else {
                    $q->where('parent_id', 0);
                }
            })->get()->toArray();

            // Enhance each sector data by retrieving and adding sub-sectors
            foreach ($sectors as &$sector) {
                $sector['sub_sectors'] = EvaluationSectors::where('parent_id', (int)$sector['uid'])->get()->toArray();
            }

            // Return success response with the enhanced data
            return ['status' => 200, 'data' => $sectors];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Manage evaluation sectors based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status', 'msg', or 'error' keys.
     */
    public static function Manage($request)
    {
        try {
            // Validate input parameters
            $input = $request->input();
            $validator = Validator::make($input, [
                'sectors' => 'required|array',
                'sectors.*.title' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Delete existing sectors based on the parent_id in the request
            if ($request->parent_id == null) {
                EvaluationSectors::where('parent_id', 0)->delete();
            } else {
                EvaluationSectors::where('parent_id', (int)$request->parent_id)->delete();
            }

            // Prepare data for new sectors and insert them into the database
            $sectors = [];
            foreach ($input['sectors'] as $k => $sector) {
                $sectors[] = [
                    'uid' => ($k + 1),
                    'title' => $sector['title'],
                    'parent_id' => isset($sector['parent_id']) ? (int)$sector['parent_id'] : 0,
                    'is_active' => isset($sector['is_active']) && $sector['is_active'] > 0 ? 1 : 0,
                ];
            }
            EvaluationSectors::insert($sectors);

            // Return success response
            return ['status' => 200, 'msg' => 'Evaluation sectors are updated successfully.'];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Get all Fair Decision sectors based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status', 'data', or 'error' keys.
     */
    public static function GetAllFdSectors($request)
    {
        try {
            // Validate input parameters
            $input = $request->input();
            $validator = Validator::make($input, [
                'keyword' => 'nullable'
            ]);
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Retrieve Fair Decision sectors based on the provided conditions
            $sectors = FairDecisionSectors::where(function ($q) use ($request) {
                if (!empty($request->keyword)) {
                    $q->where('title', 'LIKE', '%' . $request->keyword . '%');
                }
                if (!empty($request->parent_id)) {
                    $q->where('parent_id', (int)$request->parent_id);
                } else {
                    $q->where('parent_id', 0);
                }
            })->get()->toArray();

            // Include sub-sectors for each sector
            foreach ($sectors as &$sector) {
                $sector['sub_sectors'] = FairDecisionSectors::where('parent_id', (int)$sector['uid'])->get()->toArray();
            }

            // Return success response with the retrieved data
            return ['status' => 200, 'data' => $sectors];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Manage Fair Decision sectors based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status', 'msg', or 'error' keys.
     */
    public static function ManageFdSectors($request)
    {
        try {
            // Validate input parameters
            $input = $request->input();
            $validator = Validator::make($input, [
                'sectors' => 'required|array',
                'sectors.*.title' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Delete existing Fair Decision sectors based on the parent_id
            if ($request->parent_id == null) {
                FairDecisionSectors::where('parent_id', 0)->delete();
            } else {
                FairDecisionSectors::where('parent_id', (int)$request->parent_id)->delete();
            }

            // Prepare data for insertion
            $sectors = [];
            foreach ($input['sectors'] as $k => $sector) {
                $sectors[] = [
                    'uid' => ($k + 1),
                    'title' => $sector['title'],
                    'weight' => $sector['weight'] ?? 0,
                    'parent_id' => isset($sector['parent_id']) ? (int)$sector['parent_id'] : 0,
                    'is_active' => isset($sector['is_active']) && $sector['is_active'] > 0 ? 1 : 0,
                ];
            }

            // Insert Fair Decision sectors
            FairDecisionSectors::insert($sectors);

            // Return success response
            return ['status' => 200, 'msg' => 'Fair Decision sectors are updated successfully.'];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Retrieve all question groups based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status', 'data', or 'error' keys.
     */
    public static function GetAllQuestionGroups($request)
    {
        try {
            // Validate input parameters
            $input = $request->input();
            $validator = Validator::make($input, [
                'keyword' => 'nullable',
            ]);
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Retrieve question groups based on the provided conditions
            $groups = QuestionGroups::where(function ($q) use ($request) {
                if (!empty($request->keyword)) {
                    $q->where('title', 'LIKE', '%' . $request->keyword . '%');
                }
                if ($request->domain == null) {
                    $q->whereNull('domain');
                } else {
                    $q->where('domain', $request->domain);
                }
            })->get();

            // Return success response with the retrieved data
            return ['status' => 200, 'data' => $groups];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Manage question groups based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status', 'msg', or 'error' keys.
     */
    public static function ManageQuestionGroups($request)
    {
        try {
            // Validate input parameters
            $input = $request->input();
            $validator = Validator::make($input, [
                'groups' => 'required|array',
                'groups.*.title' => 'required',
                'groups.*.weight' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Manage question groups based on the provided conditions
            if ($request->domain == null) {
                // Update weights for existing question groups
                foreach ($input['groups'] as $k => $group) {
                    QuestionGroups::where('uid', (int)$group['uid'])->update([
                        'weight' => $group['weight']
                    ]);
                }
            } else {
                // Delete existing question groups for the specified domain and insert new groups
                QuestionGroups::where('domain', (int)$request->domain)->delete();
                $groups = [];
                foreach ($input['groups'] as $k => $group) {
                    $groups[] = [
                        'uid' => ($k + 5),
                        'title' => $group['title'],
                        'weight' => $group['weight'],
                        'domain' => (int)$request->domain,
                    ];
                }
                QuestionGroups::insert($groups);
            }

            // Return success response
            return ['status' => 200, 'msg' => 'Question Groups are updated successfully.'];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

}
