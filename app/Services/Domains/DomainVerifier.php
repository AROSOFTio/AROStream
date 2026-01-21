<?php

namespace App\Services\Domains;

use App\Models\Domain;
use Illuminate\Support\Facades\Log;

class DomainVerifier
{
    public function verify(Domain $domain): bool
    {
        $hostname = config('streaming.dns_verification_prefix') . '.' . $domain->hostname;
        $records = dns_get_record($hostname, DNS_TXT);

        foreach ($records as $record) {
            if (($record['txt'] ?? null) === $domain->verification_token) {
                $domain->forceFill([
                    'verified_at' => now(),
                    'ssl_status' => 'pending',
                ])->save();

                return true;
            }
        }

        Log::info('Domain verification failed', [
            'domain' => $domain->hostname,
            'records' => $records,
        ]);

        return false;
    }
}
