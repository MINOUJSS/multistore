        <style>
            /* this is the defaulte theme */
            .search-box,
            .cart-badge,
            .footer {
                background-color: {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            .order-form {
                border: 1px solid {{ get_store_parimary_color(tenant('id')) }} !important;
                box-shadow: 0 0 5px {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            .btn-primary {
                border: 1px solid {{ get_store_parimary_color(tenant('id')) }} !important;
                background-color: {{ get_store_parimary_color(tenant('id')) }} !important;
                color: {{get_store_footer_text_color(tenant('id'))}} !important;
            }

            .btn-primary:hover {
                box-shadow: 0 0 5px {{ get_store_parimary_color(tenant('id')) }} !important;
                background-color: {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            .btn-outline-primary {
                color: {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            .btn-outline-secondary {
                color: {{get_store_footer_text_color(tenant('id'))}} !important;
            }
            .btn-outline-secondary:hover {
                background-color: {{ get_store_parimary_color(tenant('id')) }} !important;
                filter: brightness(0.7);
            }

            .btn-outline-primary:hover {
                background-color: {{ get_store_parimary_color(tenant('id')) }} !important;
                box-shadow: 0 0 5px {{ get_store_parimary_color(tenant('id')) }} !important;
                color: {{get_store_footer_text_color(tenant('id'))}} !important;
            }

            .icon-circle {
                background-color: {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            .btn-secondary {
                border: 1px solid {{ get_store_secondary_color(tenant('id')) }} !important;
                background-color: {{ get_store_secondary_color(tenant('id')) }} !important;
            }

            .product-name,
            .title,
            .sub-title,.price,.card-title {
                color: {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            #carouselExampleIndicators {
                box-shadow: 0 0 5px {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            .accordion-button:focus {
                border: 1px solid {{ get_store_parimary_color(tenant('id')) }} !important;
                box-shadow: 0 0 5px {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            select {
                border: 1px solid {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            select:focus {
                box-shadow: 0 0 5px {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            input,textarea {
                border: 1px solid {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            input.form-control:focus,textarea:focus {
                box-shadow: 0 0 5px {{ get_store_parimary_color(tenant('id')) }} !important;
            }

            .btn {
                border: 1px solid {{ get_store_parimary_color(tenant('id')) }} !important;
            }


            .item-details a {
                color: {{ get_store_body_text_color(tenant('id')) }};
            }

            .footer,
            .footer-footer a,
            .footer-li a,
            .footer-li a:hover {
                color: {{ get_store_footer_text_color(tenant('id')) }};
            }
        </style>