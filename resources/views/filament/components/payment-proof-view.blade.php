<div>
    @if($getRecord() && $getRecord()->payment_proof)
        <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; max-width: 400px;">
            <img src="{{ asset('storage/' . $getRecord()->payment_proof) }}"
                 alt="Bukti Pembayaran"
                 style="width: 100%; height: auto; display: block;">
        </div>
        <p style="margin-top: 0.5rem; font-size: 0.8rem; color: #6b7280;">
            File: {{ basename($getRecord()->payment_proof) }}
        </p>
    @else
        <p style="color: #9ca3af;">Belum ada bukti pembayaran.</p>
    @endif
</div>
