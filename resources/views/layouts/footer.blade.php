<footer class="erp-footer">

    <div class="erp-footer-accent"></div>

    <div class="erp-footer-inner">

        <!-- Left: Copyright -->
        <div class="erp-footer-left">

            <div class="erp-footer-logo">
                <i class="bi bi-grid-1x2-fill"></i>
            </div>

            <div class="erp-footer-copyright">
                <span class="erp-footer-brand">
                    ERP Pro
                </span>

                <span class="erp-footer-divider">·</span>

                <span class="erp-footer-muted">
                    © {{ date('Y') }} All rights reserved.
                </span>
            </div>

        </div>

        <!-- Center: System Information -->
        <div class="erp-footer-center">
            <i class="bi bi-buildings"></i>
            <span>Enterprise Resource Planning System</span>
        </div>

        <!-- Right: Status -->
        <div class="erp-footer-right">

            <span class="erp-footer-status-dot"></span>

            <span class="erp-footer-status-text">
                ERP Workspace
            </span>

        </div>

    </div>

</footer>

<style>
    .erp-footer {
        position: relative;
        width: 100%;
        margin-top: auto;

        background: #ffffff;
        border-top: 1px solid #e8edf5;

        font-family: 'Inter', Arial, sans-serif;
    }

    /* Gradient accent */
    .erp-footer-accent {
        height: 2px;
        width: 100%;

        background: linear-gradient(
            90deg,
            #6366f1 0%,
            #818cf8 35%,
            #c4b5fd 65%,
            transparent 100%
        );
    }

    /* Main footer layout */
    .erp-footer-inner {
        min-height: 68px;

        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 20px;

        padding: 14px 28px;
    }

    /* Left section */
    .erp-footer-left {
        display: flex;
        align-items: center;
        gap: 11px;

        min-width: 0;
    }

    .erp-footer-logo {
        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        color: #ffffff;
        font-size: 15px;

        background: linear-gradient(
            135deg,
            #6366f1,
            #4f46e5
        );

        border-radius: 10px;

        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.18);
    }

    .erp-footer-copyright {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        font-size: 12px;
    }

    .erp-footer-brand {
        color: #111827;
        font-weight: 800;
        letter-spacing: -0.3px;
    }

    .erp-footer-divider {
        color: #cbd5e1;
        font-weight: 700;
    }

    .erp-footer-muted {
        color: #94a3b8;
        font-weight: 500;
    }

    /* Center section */
    .erp-footer-center {
        display: flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        color: #64748b;
        font-size: 12px;
        font-weight: 500;

        text-align: center;
    }

    .erp-footer-center i {
        color: #818cf8;
        font-size: 15px;
    }

    /* Right section */
    .erp-footer-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 8px;

        white-space: nowrap;
    }

    .erp-footer-status-dot {
        width: 7px;
        height: 7px;

        background: #10b981;
        border-radius: 50%;

        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.10);
    }

    .erp-footer-status-text {
        color: #64748b;

        font-size: 11px;
        font-weight: 600;

        letter-spacing: 0.2px;
    }

    /* Hover effects */
    .erp-footer-logo {
        transition: transform 0.25s ease;
    }

    .erp-footer-left:hover .erp-footer-logo {
        transform: translateY(-2px);
    }

    /* Tablet */
    @media (max-width: 991.98px) {
        .erp-footer-inner {
            padding: 15px 20px;
            gap: 14px;
        }

        .erp-footer-center {
            display: none;
        }

        .erp-footer-inner {
            justify-content: space-between;
        }
    }

    /* Mobile */
    @media (max-width: 575.98px) {
        .erp-footer-inner {
            flex-direction: column;
            align-items: flex-start;

            gap: 12px;

            padding: 18px 16px;
        }

        .erp-footer-left {
            width: 100%;
        }

        .erp-footer-right {
            justify-content: flex-start;
            padding-left: 45px;
        }

        .erp-footer-copyright {
            gap: 5px;
        }

        .erp-footer-muted {
            font-size: 11px;
        }
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
        .erp-footer-logo {
            transition: none;
        }
    }
</style>

