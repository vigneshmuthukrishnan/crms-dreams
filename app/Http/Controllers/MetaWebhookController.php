<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Lead;
use App\Models\Company;

class MetaWebhookController extends Controller
{

    // Step 1: Verify webhook
    public function verify(Request $request)
    {
        $verifyToken = env('META_VERIFY_TOKEN');

        if (
            $request->hub_mode === 'subscribe' &&
            $request->hub_verify_token === $verifyToken
        ) {
            return response($request->hub_challenge, 200);
        }

        return response('Unauthorized', 403);
    }

    // Step 2: Handle lead event
    public function handle(Request $request)
    {
        Log::info('Meta Webhook Received', $request->all());

        $entry = $request->entry[0]['changes'][0]['value'] ?? null;

        if (!$entry || empty($entry['leadgen_id'])) {
            return response()->json(['status' => 'ignored']);
        }

        $leadId = $entry['leadgen_id'];

        $this->fetchAndStoreLead($leadId);

        return response()->json(['status' => 'success']);
    }

    // Step 3: Fetch full lead data
    private function fetchAndStoreLead($leadId)
    {
        $token = env('META_PAGE_TOKEN');

        $response = Http::get("https://graph.facebook.com/v19.0/{$leadId}", [
            'access_token' => $token
        ]);

        if (!$response->successful()) {
            Log::error('Meta Lead Fetch Failed', $response->json());
            return;
        }

        $lead = $response->json();

        $data = [];
        foreach ($lead['field_data'] as $field) {
            $data[$field['name']] = $field['values'][0] ?? null;
        }

        $leadModel = Lead::create([
            'name'   => $data['full_name'] ?? null,
            'email'  => $data['email'] ?? null,
            'phone'  => $data['phone_number'] ?? null,
            'source' => 'meta_ads',
            'company_id' => null,
        ]);

        $company = Company::firstOrCreate([
            'name'  => $data['company_name'] ?? $data['full_name'],
            'email' => $data['email'] ?? null,
            'phone_1' => $data['phone_number'] ?? null,
        ]);
        $leadModel->update([
            'company_id' => $company->id
        ]);
    }

}
