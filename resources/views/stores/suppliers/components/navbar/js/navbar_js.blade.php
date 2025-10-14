<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownItems = document.querySelectorAll('#categoryDropdown .dropdown-item');
    const categoryDropdownBtn = document.getElementById('categoryDropdownBtn');
    const selectedCategoryInput = document.getElementById('selectedCategory');
    
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get category data
            const categoryId = this.getAttribute('data-category-id');
            const categoryName = this.textContent;
            
            // Update the hidden input value
            selectedCategoryInput.value = categoryId;
            
            // Update the dropdown button text
            categoryDropdownBtn.textContent = categoryName;
            
            // Optional: Close the dropdown
            const dropdown = bootstrap.Dropdown.getInstance(categoryDropdownBtn);
            dropdown.hide();
        });
    });
});
</script>
