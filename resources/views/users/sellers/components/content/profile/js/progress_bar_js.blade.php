<script>
    /**
     * Calculate profile completion percentage
     * @param {object} seller - The seller data object
     * @returns {number} - Completion percentage (0-100)
     */
    function calculateProfileCompletion(seller) {
        const requiredFields = [
        'full_name',
        'last_name',
        'first_name',
        'store_name',
        'wilaya',
        'dayra',
        'baladia',
        'address',
        'sex',
        'birth_date',
        'avatar',
        'id_card_image',
        'public_key',
        'secret_key',
        'name',
        'bank_name',
        'account_number',
        ];

        let completedFields = 0;

        requiredFields.forEach(field => {
            if (seller[field] && seller[field].toString().trim() !== '') {
                completedFields++;
            }
        });

        // Calculate percentage (rounded to nearest integer)
        return Math.round((completedFields / requiredFields.length) * 100);
    }

    /**
     * Update the profile completion UI
     * @param {number} percentage - The completion percentage (0-100)
     */
    function updateProfileProgress(percentage) {
        const progressElement = document.querySelector('.progress-bar');
        const percentageElement = document.querySelector('.text-primary.fw-bold');

        if (progressElement && percentageElement) {
            progressElement.style.width = `${percentage}%`;
            progressElement.setAttribute('aria-valuenow', percentage);
            percentageElement.textContent = `${percentage}%`;

            // Optional: Change color based on percentage
            if (percentage < 30) {
                progressElement.classList.remove('bg-primary', 'bg-success');
                progressElement.classList.add('bg-danger');
            } else if (percentage < 80) {
                progressElement.classList.remove('bg-danger', 'bg-success');
                progressElement.classList.add('bg-primary');
            } else {
                progressElement.classList.remove('bg-danger', 'bg-primary');
                progressElement.classList.add('bg-success');
            }
        }
    }



    // Example usage when page loads or profile updates:
document.addEventListener('DOMContentLoaded', function() {
    // Get your seller data (replace with actual data fetch)
    // const sellerData = {
    //     full_name: 'John Doe',
    //     email: 'john@example.com',
    //     phone: '123456789',
    //     business_name: 'My Business',
    //     business_type: 'Retail',
    //     avatar: 'path/to/avatar.jpg',
    //     address: '',
    //     commercial_register: '',
    //     tax_number: ''
    // };

    // console.log(@json(get_seller_data(auth()->user()->tenant_id)->toArray()));
const sellerData = @json(
    array_merge(
        get_seller_data(auth()->user()->tenant_id) ? get_seller_data(auth()->user()->tenant_id)->toArray() : [],
        optional(get_user_data(auth()->user()->tenant_id)->chargilySettings)?->toArray() ?? [],
        optional(get_user_data(auth()->user()->tenant_id)->bank_settings)?->toArray() ?? []
    )
);
    
    const completionPercentage = calculateProfileCompletion(sellerData);
    updateProfileProgress(completionPercentage);
});
</script>
