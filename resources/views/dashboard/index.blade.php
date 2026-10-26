@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid py-4 erp-dashboard">


{{-- =====================================================
     HERO HEADER
====================================================== --}}

<section class="dashboard-hero mb-4">

    <div class="hero-content">

        <div class="hero-eyebrow">
            <span class="live-indicator"></span>
            BUSINESS INTELLIGENCE
        </div>

        <h1>Business Overview<span>.</span></h1>

        <p>
            Monitor your business performance, track revenue,
            and manage your operations from one place.
        </p>

        <div class="hero-meta">
            <span>
                <i class="bi bi-calendar3"></i>
                {{ now()->format('l, d F Y') }}
            </span>

            <span class="hero-meta-divider"></span>

            <span>
                <i class="bi bi-clock-history"></i>
                {{ now()->format('h:i A') }}
            </span>
        </div>

    </div>

    <div class="hero-actions d-print-none">

        <a href="{{ route('reports.index') }}" class="hero-report-btn">
            <i class="bi bi-bar-chart-line me-2"></i>
            Business Reports
            <i class="bi bi-arrow-up-right ms-2"></i>
        </a>

        <a href="{{ route('sales.create') }}" class="hero-primary-btn">
            <i class="bi bi-plus-lg me-2"></i>
            Create Sale
        </a>

    </div>

    <div class="hero-decoration hero-decoration-one"></div>
    <div class="hero-decoration hero-decoration-two"></div>

</section>


{{-- =====================================================
     FINANCIAL KPI CARDS
====================================================== --}}

<div class="section-heading mb-3">

    <div>
        <span class="section-eyebrow">FINANCIAL PERFORMANCE</span>
        <h4>Revenue & Profit</h4>
    </div>

    <span class="section-period">
        <i class="bi bi-calendar-range me-1"></i>
        Monthly overview
    </span>

</div>


<div class="row g-3 g-xl-4 mb-4">

    {{-- TODAY SALES --}}
    <div class="col-xl-3 col-md-6">

        <div class="metric-card metric-sales h-100">

            <div class="metric-top">
                <div class="metric-icon">
                    <i class="bi bi-bag-check"></i>
                </div>

                <span class="metric-period">TODAY</span>
            </div>

            <div class="metric-label">Today's Sales</div>

            <div class="metric-value">
                <span class="metric-currency">PKR</span>
                {{ number_format($todaySales, 2) }}
            </div>

            <div class="metric-footer">
                <span class="metric-footer-icon">
                    <i class="bi bi-calendar-check"></i>
                </span>
                Revenue recorded today
            </div>

            <div class="metric-decoration"></div>

        </div>

    </div>


    {{-- MONTHLY SALES --}}
    <div class="col-xl-3 col-md-6">

        <div class="metric-card metric-revenue h-100">

            <div class="metric-top">
                <div class="metric-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>

                <span class="metric-period">MONTH</span>
            </div>

            <div class="metric-label">Monthly Sales</div>

            <div class="metric-value">
                <span class="metric-currency">PKR</span>
                {{ number_format($monthlySales, 2) }}
            </div>

            <div class="metric-footer">
                <span class="metric-footer-icon">
                    <i class="bi bi-bar-chart-line"></i>
                </span>
                Revenue this month
            </div>

            <div class="metric-decoration"></div>

        </div>

    </div>


    {{-- EXPENSES --}}
    <div class="col-xl-3 col-md-6">

        <div class="metric-card metric-expenses h-100">

            <div class="metric-top">
                <div class="metric-icon">
                    <i class="bi bi-wallet2"></i>
                </div>

                <span class="metric-period">MONTH</span>
            </div>

            <div class="metric-label">Monthly Expenses</div>

            <div class="metric-value">
                <span class="metric-currency">PKR</span>
                {{ number_format($monthlyExpenses, 2) }}
            </div>

            <div class="metric-footer">
                <span class="metric-footer-icon">
                    <i class="bi bi-receipt"></i>
                </span>
                Recorded business expenses
            </div>

            <div class="metric-decoration"></div>

        </div>

    </div>


    {{-- NET PROFIT --}}
    <div class="col-xl-3 col-md-6">

        <div class="metric-card metric-profit h-100">

            <div class="metric-top">
                <div class="metric-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>

                <span class="metric-period">MONTH</span>
            </div>

            <div class="metric-label">Net Profit</div>

            <div class="metric-value {{ $netProfit < 0 ? 'text-danger' : '' }}">
                <span class="metric-currency">PKR</span>
                {{ number_format($netProfit, 2) }}
            </div>

            <div class="metric-footer">
                <span class="metric-footer-icon">
                    <i class="bi bi-calculator"></i>
                </span>
                After COGS and expenses
            </div>

            <div class="metric-decoration"></div>

        </div>

    </div>

</div>


{{-- =====================================================
     SALES ANALYTICS + PROFIT BREAKDOWN
====================================================== --}}

<div class="row g-4 mb-4">

    {{-- SALES CHART --}}
    <div class="col-xl-8">

        <div class="dashboard-panel h-100">

            <div class="panel-header">

                <div class="panel-title-group">

                    <div class="panel-title-icon">
                        <i class="bi bi-activity"></i>
                    </div>

                    <div>
                        <h5>Sales Analytics</h5>
                        <p>Daily revenue performance for the current month</p>
                    </div>

                </div>

                <span class="panel-badge">
                    <span class="live-indicator"></span>
                    This Month
                </span>

            </div>

            <div class="panel-body">

                <div class="chart-summary mb-3">

                    <div>
                        <span class="chart-summary-label">Monthly Revenue</span>
                        <h3>
                            PKR {{ number_format($monthlySales, 2) }}
                        </h3>
                    </div>

                    <div class="chart-summary-icon">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>

                </div>

                <div class="sales-chart-container">
                    <canvas id="salesChart"></canvas>
                </div>

            </div>

        </div>

    </div>


    {{-- PROFIT BREAKDOWN --}}
    <div class="col-xl-4">

        <div class="dashboard-panel h-100">

            <div class="panel-header">

                <div class="panel-title-group">

                    <div class="panel-title-icon profit-panel-icon">
                        <i class="bi bi-pie-chart"></i>
                    </div>

                    <div>
                        <h5>Profit Breakdown</h5>
                        <p>Current month financial summary</p>
                    </div>

                </div>

            </div>

            <div class="panel-body">

                <div class="profit-highlight mb-4">

                    <span>Net Profit</span>

                    <h3 class="{{ $netProfit < 0 ? 'text-danger' : '' }}">
                        PKR {{ number_format($netProfit, 2) }}
                    </h3>

                    <div class="profit-highlight-caption">
                        <i class="bi bi-info-circle me-1"></i>
                        Calculated from current dashboard data
                    </div>

                </div>


                <div class="profit-breakdown-list">

                    <div class="profit-breakdown-item">

                        <span class="breakdown-label">
                            <span class="breakdown-dot dot-sales"></span>
                            Total Sales
                        </span>

                        <strong>
                            PKR {{ number_format($monthlySales, 2) }}
                        </strong>

                    </div>


                    <div class="profit-breakdown-item">

                        <span class="breakdown-label">
                            <span class="breakdown-dot dot-cogs"></span>
                            Cost of Goods
                        </span>

                        <strong class="text-danger">
                            − PKR {{ number_format($monthlyCogs, 2) }}
                        </strong>

                    </div>


                    <div class="profit-breakdown-item">

                        <span class="breakdown-label">
                            <span class="breakdown-dot dot-gross"></span>
                            Gross Profit
                        </span>

                        <strong class="text-success">
                            PKR {{ number_format($grossProfit, 2) }}
                        </strong>

                    </div>


                    <div class="profit-breakdown-item">

                        <span class="breakdown-label">
                            <span class="breakdown-dot dot-expenses"></span>
                            Expenses
                        </span>

                        <strong class="text-danger">
                            − PKR {{ number_format($monthlyExpenses, 2) }}
                        </strong>

                    </div>

                </div>


                <div class="profit-formula mt-3">
                    <i class="bi bi-calculator me-2"></i>
                    Net Profit = Gross Profit − Expenses
                </div>

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     BUSINESS INVENTORY STATISTICS
====================================================== --}}

<div class="section-heading mb-3">

    <div>
        <span class="section-eyebrow">BUSINESS OPERATIONS</span>
        <h4>Inventory & Relationships</h4>
    </div>

</div>


<div class="row g-3 g-xl-4 mb-4">

    {{-- CUSTOMERS --}}
    <div class="col-xl-3 col-md-6">

        <div class="business-stat-card h-100">

            <div class="business-stat-icon icon-customers">
                <i class="bi bi-people"></i>
            </div>

            <div class="business-stat-content">
                <span>Total Customers</span>
                <h3>{{ number_format($totalCustomers) }}</h3>
                <small>Registered customers</small>
            </div>

            <i class="bi bi-arrow-up-right stat-corner-icon"></i>

        </div>

    </div>


    {{-- SUPPLIERS --}}
    <div class="col-xl-3 col-md-6">

        <div class="business-stat-card h-100">

            <div class="business-stat-icon icon-suppliers">
                <i class="bi bi-buildings"></i>
            </div>

            <div class="business-stat-content">
                <span>Total Suppliers</span>
                <h3>{{ number_format($totalSuppliers) }}</h3>
                <small>Business suppliers</small>
            </div>

            <i class="bi bi-arrow-up-right stat-corner-icon"></i>

        </div>

    </div>


    {{-- PRODUCTS --}}
    <div class="col-xl-3 col-md-6">

        <div class="business-stat-card h-100">

            <div class="business-stat-icon icon-products">
                <i class="bi bi-box-seam"></i>
            </div>

            <div class="business-stat-content">
                <span>Total Products</span>
                <h3>{{ number_format($totalProducts) }}</h3>
                <small>Products in catalog</small>
            </div>

            <i class="bi bi-arrow-up-right stat-corner-icon"></i>

        </div>

    </div>


    {{-- STOCK --}}
    <div class="col-xl-3 col-md-6">

        <div class="business-stat-card h-100">

            <div class="business-stat-icon icon-stock">
                <i class="bi bi-boxes"></i>
            </div>

            <div class="business-stat-content">
                <span>Total Stock Units</span>
                <h3>{{ number_format($totalStock) }}</h3>
                <small>Current recorded inventory</small>
            </div>

            <i class="bi bi-arrow-up-right stat-corner-icon"></i>

        </div>

    </div>

</div>


{{-- =====================================================
     RECENT SALES + LOW STOCK
====================================================== --}}

<div class="row g-4 mb-4">

    {{-- RECENT SALES --}}
    <div class="col-xl-8">

        <div class="dashboard-panel h-100">

            <div class="panel-header">

                <div class="panel-title-group">

                    <div class="panel-title-icon">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>

                    <div>
                        <h5>Recent Sales</h5>
                        <p>Review your latest invoices and transactions</p>
                    </div>

                </div>

                <a href="{{ route('sales.index') }}" class="panel-link">
                    View all <i class="bi bi-arrow-up-right ms-1"></i>
                </a>

            </div>


            <div class="table-responsive">

                <table class="table recent-sales-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th class="ps-4">Invoice</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Amount</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentSales as $sale)

                            <tr>

                                <td class="ps-4">

                                    <a href="{{ route('sales.show', $sale) }}"
                                       class="recent-invoice-link">

                                        <span class="invoice-table-icon">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </span>

                                        {{ $sale->invoice_number }}

                                    </a>

                                </td>

                                <td>
                                    <span class="table-customer-name">
                                        {{ $sale->customer->name ?? 'Walk-in Customer' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="table-date">
                                        {{ $sale->sale_date->format('d M Y') }}
                                    </span>
                                </td>

                                <td class="text-end pe-4">

                                    <span class="table-amount">
                                        PKR {{ number_format($sale->grand_total, 2) }}
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center py-5">

                                    <div class="empty-state-icon">
                                        <i class="bi bi-receipt"></i>
                                    </div>

                                    <h6>No sales found</h6>

                                    <p class="text-muted small mb-0">
                                        Sales invoices will appear here.
                                    </p>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- LOW STOCK --}}
    <div class="col-xl-4">

        <div class="dashboard-panel h-100">

            <div class="panel-header">

                <div class="panel-title-group">

                    <div class="panel-title-icon stock-panel-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>

                    <div>
                        <h5>Stock Alerts</h5>
                        <p>Inventory requiring attention</p>
                    </div>

                </div>

                <span class="alert-count-badge">
                    {{ $lowStockProducts }}
                </span>

            </div>


            <div class="panel-body">

                @forelse($lowStockProductList as $product)

                    <div class="stock-alert-item">

                        <div class="stock-item-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <div class="stock-item-details">

                            <h6>{{ $product->name }}</h6>

                            <span>
                                Minimum stock: {{ $product->minimum_stock }}
                            </span>

                            <div class="stock-progress-track">
                                <div
                                    class="stock-progress-fill"
                                    style="width: {{ $product->minimum_stock > 0 ? min(100, ($product->stock / $product->minimum_stock) * 100) : 0 }}%">
                                </div>
                            </div>

                        </div>

                        <div class="stock-quantity">
                            <strong>{{ $product->stock }}</strong>
                            <small>left</small>
                        </div>

                    </div>

                @empty

                    <div class="stock-all-good">

                        <div class="stock-good-icon">
                            <i class="bi bi-check2-circle"></i>
                        </div>

                        <h6>Inventory looks good!</h6>

                        <p>All products have sufficient stock.</p>

                    </div>

                @endforelse


                @if($lowStockProducts > 0)

                    <a href="{{ route('notifications.index') }}"
                       class="stock-alert-link mt-3">

                        Review stock alerts
                        <i class="bi bi-arrow-right"></i>

                    </a>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     TOP PRODUCTS + QUICK ACTIONS
====================================================== --}}

<div class="row g-4 mb-4">

    {{-- TOP PRODUCTS --}}
    <div class="col-xl-7">

        <div class="dashboard-panel h-100">

            <div class="panel-header">

                <div class="panel-title-group">

                    <div class="panel-title-icon products-panel-icon">
                        <i class="bi bi-trophy"></i>
                    </div>

                    <div>
                        <h5>Top Selling Products</h5>
                        <p>Your best performing products</p>
                    </div>

                </div>

                <span class="panel-badge">TOP PERFORMERS</span>

            </div>


            <div class="panel-body">

                @forelse($topProducts as $index => $product)

                    <div class="top-product-item">

                        <div class="product-rank rank-{{ $index + 1 }}">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>

                        <div class="top-product-details">

                            <h6>{{ $product->name }}</h6>

                            <span>
                                {{ number_format($product->total_quantity) }}
                                units sold
                            </span>

                        </div>

                        <div class="top-product-revenue">

                            <strong>
                                PKR {{ number_format($product->total_sales, 2) }}
                            </strong>

                            <small>Total sales</small>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-5">

                        <div class="empty-state-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <h6>No product sales available</h6>

                        <p class="text-muted small mb-0">
                            Top-selling products will appear here.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- QUICK ACTIONS --}}
    <div class="col-xl-5">

        <div class="dashboard-panel h-100">

            <div class="panel-header">

                <div class="panel-title-group">

                    <div class="panel-title-icon actions-panel-icon">
                        <i class="bi bi-lightning-charge"></i>
                    </div>

                    <div>
                        <h5>Quick Actions</h5>
                        <p>Access your daily operations</p>
                    </div>

                </div>

            </div>


            <div class="panel-body">

                <div class="quick-actions-grid">

                    <a href="{{ route('sales.create') }}" class="quick-action-card">
                        <span class="quick-action-icon action-sale">
                            <i class="bi bi-cart-plus"></i>
                        </span>
                        <span class="quick-action-label">New Sale</span>
                        <i class="bi bi-arrow-up-right quick-action-arrow"></i>
                    </a>


                    <a href="{{ route('products.create') }}" class="quick-action-card">
                        <span class="quick-action-icon action-product">
                            <i class="bi bi-box-seam"></i>
                        </span>
                        <span class="quick-action-label">Add Product</span>
                        <i class="bi bi-arrow-up-right quick-action-arrow"></i>
                    </a>


                    <a href="{{ route('customers.create') }}" class="quick-action-card">
                        <span class="quick-action-icon action-customer">
                            <i class="bi bi-person-plus"></i>
                        </span>
                        <span class="quick-action-label">Add Customer</span>
                        <i class="bi bi-arrow-up-right quick-action-arrow"></i>
                    </a>


                    <a href="{{ route('expenses.create') }}" class="quick-action-card">
                        <span class="quick-action-icon action-expense">
                            <i class="bi bi-wallet2"></i>
                        </span>
                        <span class="quick-action-label">Add Expense</span>
                        <i class="bi bi-arrow-up-right quick-action-arrow"></i>
                    </a>


                    <a href="{{ route('reports.index') }}" class="quick-action-card">
                        <span class="quick-action-icon action-report">
                            <i class="bi bi-bar-chart-line"></i>
                        </span>
                        <span class="quick-action-label">Reports</span>
                        <i class="bi bi-arrow-up-right quick-action-arrow"></i>
                    </a>


                    <a href="{{ route('accounting.index') }}" class="quick-action-card">
                        <span class="quick-action-icon action-accounting">
                            <i class="bi bi-calculator"></i>
                        </span>
                        <span class="quick-action-label">Accounting</span>
                        <i class="bi bi-arrow-up-right quick-action-arrow"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     INVENTORY ALERT SUMMARY
====================================================== --}}

<div class="section-heading mb-3">

    <div>
        <span class="section-eyebrow">INVENTORY HEALTH</span>
        <h4>Stock Monitoring</h4>
    </div>

    <a href="{{ route('notifications.index') }}" class="panel-link">
        View notifications
        <i class="bi bi-arrow-up-right ms-1"></i>
    </a>

</div>


<div class="row g-3 mb-4">

    {{-- LOW STOCK --}}
    <div class="col-md-6">

        <div class="inventory-health-card health-warning">

            <div class="health-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>

            <div class="health-content">

                <span>Low Stock Products</span>

                <h3>{{ number_format($lowStockProducts) }}</h3>

                <small>Products need replenishment</small>

            </div>

            <div class="health-decoration">
                <i class="bi bi-box-seam"></i>
            </div>

            @if($lowStockProducts > 0)
                <a href="{{ route('notifications.index') }}"
                   class="health-view-btn"
                   aria-label="View low stock notifications">
                    <i class="bi bi-arrow-up-right"></i>
                </a>
            @endif

        </div>

    </div>


    {{-- OUT OF STOCK --}}
    <div class="col-md-6">

        <div class="inventory-health-card health-danger">

            <div class="health-icon">
                <i class="bi bi-x-circle"></i>
            </div>

            <div class="health-content">

                <span>Out of Stock Products</span>

                <h3>{{ number_format($outOfStockProducts) }}</h3>

                <small>Products currently unavailable</small>

            </div>

            <div class="health-decoration">
                <i class="bi bi-boxes"></i>
            </div>

            @if($outOfStockProducts > 0)
                <a href="{{ route('notifications.index') }}"
                   class="health-view-btn"
                   aria-label="View out of stock notifications">
                    <i class="bi bi-arrow-up-right"></i>
                </a>
            @endif

        </div>

    </div>

</div>


{{-- FOOTER --}}
<div class="dashboard-footer">

    <div>
        <span class="footer-brand-mark">
            <i class="bi bi-grid-1x2-fill"></i>
        </span>

        <strong>ERP PRO</strong>

        <span class="footer-divider">/</span>

        <span>Business Management System</span>
    </div>

    <span>
        <i class="bi bi-shield-check me-1"></i>
        Dashboard overview
    </span>

</div>


</div>

{{-- =====================================================
CHART.JS
====================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(function () {

    function initializeSalesChart() {

        const canvas = document.getElementById('salesChart');

        if (!canvas || typeof Chart === 'undefined') {
            return;
        }

        if (canvas.dataset.initialized === 'true') {
            return;
        }

        canvas.dataset.initialized = 'true';

        const chartData = @json($chartData);

        const labels = chartData.map(item => item.date);
        const sales = chartData.map(item => Number(item.sales) || 0);

        const context = canvas.getContext('2d');

        const gradient = context.createLinearGradient(0, 0, 0, 320);

        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.24)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.01)');

        new Chart(context, {

            type: 'line',

            data: {
                labels: labels,

                datasets: [{
                    label: 'Sales',
                    data: sales,
                    borderColor: '#6366f1',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.38,
                    borderWidth: 3,
                    pointRadius: labels.length > 18 ? 0 : 3,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#6366f1',
                    pointBorderWidth: 2
                }]
            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false,

                        callbacks: {
                            label: function (context) {
                                return 'PKR ' + Number(context.raw).toLocaleString(
                                    'en-PK',
                                    {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }
                                );
                            }
                        }
                    }

                },

                scales: {

                    y: {
                        beginAtZero: true,

                        border: {
                            display: false
                        },

                        grid: {
                            color: '#edf0f7',
                            drawTicks: false
                        },

                        ticks: {
                            padding: 12,
                            color: '#94a3b8',

                            callback: function (value) {
                                return 'PKR ' + Number(value).toLocaleString('en-PK');
                            }
                        }
                    },

                    x: {

                        border: {
                            display: false
                        },

                        grid: {
                            display: false
                        },

                        ticks: {
                            color: '#94a3b8',
                            maxRotation: 0,
                            autoSkip: true,
                            maxTicksLimit: 10
                        }

                    }

                }

            }

        });

    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSalesChart);
    } else {
        initializeSalesChart();
    }

})();
</script>

{{-- =====================================================
DASHBOARD STYLES
====================================================== --}}

<style>

/* -----------------------------------------------------
   BASE
----------------------------------------------------- */

.erp-dashboard {
    --erp-primary: #4f46e5;
    --erp-primary-light: #eef2ff;
    --erp-heading: #111827;
    --erp-muted: #64748b;
    --erp-border: #e9edf5;
    --erp-surface: #ffffff;
    color: var(--erp-heading);
}

.erp-dashboard *,
.erp-dashboard *::before,
.erp-dashboard *::after {
    box-sizing: border-box;
}

.erp-dashboard a {
    text-decoration: none;
}

.erp-dashboard .text-muted {
    color: var(--erp-muted) !important;
}


/* -----------------------------------------------------
   HERO
----------------------------------------------------- */

.dashboard-hero {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
    min-height: 225px;
    padding: 35px 38px;
    border-radius: 24px;
    background: linear-gradient(115deg, #111827 0%, #1e1b4b 58%, #312e81 100%);
    color: #ffffff;
    box-shadow: 0 18px 45px rgba(30, 27, 75, 0.17);
}

.hero-content,
.hero-actions {
    position: relative;
    z-index: 2;
}

.hero-content {
    max-width: 650px;
}

.hero-eyebrow {
    display: flex;
    align-items: center;
    gap: 9px;
    color: #c7d2fe;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2px;
    margin-bottom: 16px;
}

.live-indicator {
    width: 7px;
    height: 7px;
    display: inline-block;
    flex-shrink: 0;
    border-radius: 50%;
    background: #34d399;
    box-shadow: 0 0 0 4px rgba(52, 211, 153, 0.12);
}

.dashboard-hero h1 {
    margin: 0 0 12px;
    color: #ffffff;
    font-size: clamp(29px, 3vw, 42px);
    font-weight: 850;
    letter-spacing: -1.5px;
}

.dashboard-hero h1 span {
    color: #818cf8;
}

.dashboard-hero p {
    max-width: 530px;
    color: #cbd5e1;
    font-size: 14px;
    line-height: 1.8;
    margin-bottom: 20px;
}

.hero-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 14px;
    color: #cbd5e1;
    font-size: 12px;
}

.hero-meta span:not(.hero-meta-divider) {
    display: inline-flex;
    align-items: center;
    gap: 7px;
}

.hero-meta-divider {
    width: 1px;
    height: 15px;
    background: rgba(255, 255, 255, 0.25);
}

.hero-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    min-width: 190px;
}

.hero-report-btn,
.hero-primary-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 13px 17px;
    border-radius: 11px;
    font-size: 12px;
    font-weight: 700;
    transition: all .2s ease;
}

.hero-report-btn {
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, .25);
    background: rgba(255, 255, 255, .07);
}

.hero-primary-btn {
    color: #ffffff;
    background: #6366f1;
    box-shadow: 0 7px 20px rgba(99, 102, 241, .25);
}

.hero-report-btn:hover,
.hero-primary-btn:hover {
    color: #ffffff;
    transform: translateY(-2px);
}

.hero-report-btn:hover {
    background: rgba(255, 255, 255, .13);
}

.hero-primary-btn:hover {
    background: #4f46e5;
}

.hero-decoration {
    position: absolute;
    border: 1px solid rgba(255, 255, 255, .06);
    border-radius: 50%;
    pointer-events: none;
}

.hero-decoration-one {
    width: 340px;
    height: 340px;
    right: 10%;
    top: -220px;
}

.hero-decoration-two {
    width: 260px;
    height: 260px;
    right: 2%;
    bottom: -205px;
}


/* -----------------------------------------------------
   SECTION HEADINGS
----------------------------------------------------- */

.section-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 15px;
}

.section-eyebrow {
    display: block;
    color: #818cf8;
    font-size: 9px;
    font-weight: 850;
    letter-spacing: 1.5px;
    margin-bottom: 5px;
}

.section-heading h4 {
    margin: 0;
    color: #111827;
    font-size: 19px;
    font-weight: 800;
    letter-spacing: -.4px;
}

.section-period {
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
    padding: 8px 12px;
    border: 1px solid #e9edf5;
    background: #ffffff;
    border-radius: 9px;
}


/* -----------------------------------------------------
   KPI CARDS
----------------------------------------------------- */

.metric-card {
    position: relative;
    overflow: hidden;
    min-width: 0;
    padding: 22px;
    border: 1px solid #e9edf5;
    border-radius: 19px;
    background: #ffffff;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
    transition: transform .25s ease, box-shadow .25s ease;
}

.metric-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(15, 23, 42, .08);
}

.metric-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 22px;
}

.metric-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    font-size: 21px;
}

.metric-sales .metric-icon {
    color: #4f46e5;
    background: #eef2ff;
}

.metric-revenue .metric-icon {
    color: #0891b2;
    background: #ecfeff;
}

.metric-expenses .metric-icon {
    color: #ea580c;
    background: #fff7ed;
}

.metric-profit .metric-icon {
    color: #059669;
    background: #ecfdf5;
}

.metric-period {
    padding: 6px 9px;
    border-radius: 7px;
    background: #f8fafc;
    color: #64748b;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .8px;
}

.metric-label {
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 9px;
}

.metric-value {
    position: relative;
    z-index: 1;
    color: #111827;
    font-size: clamp(19px, 1.65vw, 25px);
    font-weight: 850;
    line-height: 1.35;
    letter-spacing: -.8px;
    overflow-wrap: anywhere;
}

.metric-currency {
    color: #94a3b8;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0;
    margin-right: 2px;
}

.metric-footer {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 17px;
    color: #64748b;
    font-size: 10px;
    font-weight: 500;
}

.metric-footer-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 23px;
    height: 23px;
    border-radius: 7px;
    background: #f1f5f9;
    color: #64748b;
}

.metric-decoration {
    position: absolute;
    width: 105px;
    height: 105px;
    right: -57px;
    bottom: -61px;
    border-radius: 50%;
    background: #f8fafc;
    opacity: .8;
}


/* -----------------------------------------------------
   DASHBOARD PANELS
----------------------------------------------------- */

.dashboard-panel {
    min-width: 0;
    overflow: hidden;
    border: 1px solid #e9edf5;
    border-radius: 19px;
    background: #ffffff;
    box-shadow: 0 5px 22px rgba(15, 23, 42, .035);
}

.panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 21px 23px;
    border-bottom: 1px solid #f0f2f7;
}

.panel-title-group {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}

.panel-title-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 13px;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 19px;
}

.profit-panel-icon {
    color: #059669;
    background: #ecfdf5;
}

.stock-panel-icon {
    color: #d97706;
    background: #fffbeb;
}

.products-panel-icon {
    color: #7c3aed;
    background: #f5f3ff;
}

.actions-panel-icon {
    color: #0284c7;
    background: #f0f9ff;
}

.panel-title-group h5 {
    margin: 0 0 5px;
    color: #111827;
    font-size: 14px;
    font-weight: 800;
}

.panel-title-group p {
    margin: 0;
    color: #94a3b8;
    font-size: 10px;
    line-height: 1.6;
}

.panel-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 10px;
    border-radius: 8px;
    background: #f8fafc;
    color: #64748b;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .5px;
    white-space: nowrap;
}

.panel-badge .live-indicator {
    width: 6px;
    height: 6px;
}

.panel-body {
    padding: 22px 23px;
}

.panel-link {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    color: #4f46e5;
    font-size: 11px;
    font-weight: 750;
    white-space: nowrap;
}

.panel-link:hover {
    color: #3730a3;
}


/* -----------------------------------------------------
   SALES CHART
----------------------------------------------------- */

.chart-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.chart-summary-label {
    color: #94a3b8;
    font-size: 10px;
    font-weight: 600;
}

.chart-summary h3 {
    margin: 7px 0 0;
    color: #111827;
    font-size: 23px;
    font-weight: 850;
    letter-spacing: -.7px;
    overflow-wrap: anywhere;
}

.chart-summary-icon {
    width: 43px;
    height: 43px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    background: #eef2ff;
    color: #6366f1;
    font-size: 20px;
}

.sales-chart-container {
    position: relative;
    height: 275px;
    width: 100%;
}


/* -----------------------------------------------------
   PROFIT BREAKDOWN
----------------------------------------------------- */

.profit-highlight {
    padding: 19px;
    border: 1px solid #d1fae5;
    border-radius: 14px;
    background: linear-gradient(135deg, #ecfdf5, #f0fdfa);
}

.profit-highlight > span {
    color: #047857;
    font-size: 11px;
    font-weight: 700;
}

.profit-highlight h3 {
    margin: 10px 0;
    color: #047857;
    font-size: clamp(20px, 2vw, 25px);
    font-weight: 850;
    letter-spacing: -.7px;
    overflow-wrap: anywhere;
}

.profit-highlight-caption {
    color: #64748b;
    font-size: 9px;
}

.profit-breakdown-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 13px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 10px;
}

.profit-breakdown-item:last-child {
    border-bottom: 0;
}

.breakdown-label {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: #64748b;
}

.profit-breakdown-item > strong {
    text-align: right;
    font-size: 10px;
    overflow-wrap: anywhere;
}

.breakdown-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

.dot-sales {
    background: #6366f1;
}

.dot-cogs {
    background: #f87171;
}

.dot-gross {
    background: #10b981;
}

.dot-expenses {
    background: #f59e0b;
}

.profit-formula {
    padding: 12px;
    border-radius: 9px;
    background: #f8fafc;
    color: #64748b;
    font-size: 9px;
    line-height: 1.7;
}


/* -----------------------------------------------------
   BUSINESS STATISTICS
----------------------------------------------------- */

.business-stat-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 15px;
    overflow: hidden;
    padding: 21px 19px;
    border: 1px solid #e9edf5;
    border-radius: 17px;
    background: #ffffff;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
    transition: transform .2s ease, box-shadow .2s ease;
}

.business-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 27px rgba(15, 23, 42, .07);
}

.business-stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 14px;
    font-size: 21px;
}

.icon-customers {
    background: #eef2ff;
    color: #4f46e5;
}

.icon-suppliers {
    background: #f0f9ff;
    color: #0284c7;
}

.icon-products {
    background: #f5f3ff;
    color: #7c3aed;
}

.icon-stock {
    background: #ecfdf5;
    color: #059669;
}

.business-stat-content {
    min-width: 0;
}

.business-stat-content > span {
    color: #64748b;
    font-size: 10px;
    font-weight: 600;
}

.business-stat-content h3 {
    margin: 5px 0;
    color: #111827;
    font-size: 25px;
    font-weight: 850;
    letter-spacing: -.7px;
    overflow-wrap: anywhere;
}

.business-stat-content small {
    color: #94a3b8;
    font-size: 9px;
}

.stat-corner-icon {
    position: absolute;
    top: 17px;
    right: 17px;
    color: #cbd5e1;
    font-size: 14px;
    transition: color .2s ease;
}

.business-stat-card:hover .stat-corner-icon {
    color: #6366f1;
}


/* -----------------------------------------------------
   RECENT SALES TABLE
----------------------------------------------------- */

.recent-sales-table {
    min-width: 610px;
}

.recent-sales-table thead th {
    padding-top: 14px;
    padding-bottom: 14px;
    background: #f8fafc;
    border-bottom: 1px solid #edf0f5;
    color: #94a3b8;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .8px;
    text-transform: uppercase;
    white-space: nowrap;
}

.recent-sales-table tbody td {
    padding-top: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f1f5f9;
    color: #475569;
    font-size: 10px;
}

.recent-sales-table tbody tr:last-child td {
    border-bottom: 0;
}

.recent-sales-table tbody tr {
    transition: background .2s ease;
}

.recent-sales-table tbody tr:hover {
    background: #fafbff;
}

.recent-invoice-link {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: #4f46e5;
    font-weight: 750;
    white-space: nowrap;
}

.recent-invoice-link:hover {
    color: #3730a3;
}

.invoice-table-icon {
    width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 9px;
    background: #eef2ff;
    color: #6366f1;
    font-size: 14px;
}

.table-customer-name {
    color: #334155;
    font-weight: 600;
}

.table-date {
    color: #94a3b8;
    white-space: nowrap;
}

.table-amount {
    color: #111827;
    font-weight: 800;
    white-space: nowrap;
}

.empty-state-icon {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    border-radius: 16px;
    background: #f1f5f9;
    color: #94a3b8;
    font-size: 22px;
}

.empty-state-icon + h6 {
    color: #334155;
    font-weight: 750;
}


/* -----------------------------------------------------
   STOCK ALERTS
----------------------------------------------------- */

.alert-count-badge {
    min-width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 9px;
    background: #fff7ed;
    color: #ea580c;
    font-size: 11px;
    font-weight: 850;
}

.stock-alert-item {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 15px 0;
    border-bottom: 1px solid #f1f5f9;
}

.stock-alert-item:first-child {
    padding-top: 0;
}

.stock-alert-item:last-of-type {
    border-bottom: 0;
}

.stock-item-icon {
    width: 39px;
    height: 39px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 12px;
    background: #fff7ed;
    color: #ea580c;
    font-size: 17px;
}

.stock-item-details {
    min-width: 0;
    flex: 1;
}

.stock-item-details h6 {
    margin: 0 0 5px;
    color: #334155;
    font-size: 10px;
    font-weight: 750;
    overflow-wrap: anywhere;
}

.stock-item-details > span {
    color: #94a3b8;
    font-size: 9px;
}

.stock-progress-track {
    width: 100%;
    height: 4px;
    margin-top: 8px;
    border-radius: 5px;
    background: #f1f5f9;
    overflow: hidden;
}

.stock-progress-fill {
    height: 100%;
    border-radius: inherit;
    background: #f59e0b;
}

.stock-quantity {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    flex-shrink: 0;
}

.stock-quantity strong {
    color: #ea580c;
    font-size: 16px;
    font-weight: 850;
}

.stock-quantity small {
    color: #94a3b8;
    font-size: 9px;
}

.stock-all-good {
    text-align: center;
    padding: 30px 10px;
}

.stock-good-icon {
    width: 55px;
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    border-radius: 17px;
    background: #ecfdf5;
    color: #059669;
    font-size: 25px;
}

.stock-all-good h6 {
    color: #334155;
    font-size: 12px;
    font-weight: 800;
}

.stock-all-good p {
    color: #94a3b8;
    font-size: 10px;
}

.stock-alert-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 12px;
    border: 1px solid #e9edf5;
    border-radius: 10px;
    color: #4f46e5;
    font-size: 10px;
    font-weight: 750;
}

.stock-alert-link:hover {
    background: #f8faff;
    color: #3730a3;
}


/* -----------------------------------------------------
   TOP PRODUCTS
----------------------------------------------------- */

.top-product-item {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 15px 0;
    border-bottom: 1px solid #f1f5f9;
}

.top-product-item:first-child {
    padding-top: 0;
}

.top-product-item:last-child {
    border-bottom: 0;
    padding-bottom: 0;
}

.product-rank {
    width: 41px;
    height: 41px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 13px;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 12px;
    font-weight: 850;
}

.rank-1 {
    background: #fef3c7;
    color: #b45309;
}

.rank-2 {
    background: #f1f5f9;
    color: #475569;
}

.rank-3 {
    background: #ffedd5;
    color: #c2410c;
}

.top-product-details {
    min-width: 0;
    flex: 1;
}

.top-product-details h6 {
    margin: 0 0 5px;
    color: #334155;
    font-size: 11px;
    font-weight: 750;
    overflow-wrap: anywhere;
}

.top-product-details span {
    color: #94a3b8;
    font-size: 9px;
}

.top-product-revenue {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
    min-width: 0;
}

.top-product-revenue strong {
    color: #111827;
    font-size: 10px;
    font-weight: 800;
    text-align: right;
    overflow-wrap: anywhere;
}

.top-product-revenue small {
    color: #94a3b8;
    font-size: 9px;
}


/* -----------------------------------------------------
   QUICK ACTIONS
----------------------------------------------------- */

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 11px;
}

.quick-action-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    padding: 13px 11px;
    border: 1px solid #e9edf5;
    border-radius: 13px;
    background: #ffffff;
    transition: transform .2s ease, border-color .2s ease, background .2s ease;
}

.quick-action-card:hover {
    transform: translateY(-2px);
    border-color: #c7d2fe;
    background: #fafaff;
}

.quick-action-icon {
    width: 37px;
    height: 37px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 11px;
    font-size: 17px;
}

.action-sale {
    color: #4f46e5;
    background: #eef2ff;
}

.action-product {
    color: #0891b2;
    background: #ecfeff;
}

.action-customer {
    color: #7c3aed;
    background: #f5f3ff;
}

.action-expense {
    color: #ea580c;
    background: #fff7ed;
}

.action-report {
    color: #0284c7;
    background: #f0f9ff;
}

.action-accounting {
    color: #059669;
    background: #ecfdf5;
}

.quick-action-label {
    min-width: 0;
    color: #334155;
    font-size: 10px;
    font-weight: 750;
    line-height: 1.5;
    overflow-wrap: anywhere;
}

.quick-action-arrow {
    position: absolute;
    top: 9px;
    right: 9px;
    color: #cbd5e1;
    font-size: 11px;
    transition: color .2s ease;
}

.quick-action-card:hover .quick-action-arrow {
    color: #4f46e5;
}


/* -----------------------------------------------------
   INVENTORY HEALTH
----------------------------------------------------- */

.inventory-health-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 17px;
    min-height: 145px;
    padding: 23px;
    overflow: hidden;
    border: 1px solid #e9edf5;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
}

.health-warning {
    background: linear-gradient(115deg, #ffffff 45%, #fffbeb 100%);
}

.health-danger {
    background: linear-gradient(115deg, #ffffff 45%, #fff1f2 100%);
}

.health-icon {
    width: 53px;
    height: 53px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 16px;
    font-size: 22px;
}

.health-warning .health-icon {
    background: #fef3c7;
    color: #d97706;
}

.health-danger .health-icon {
    background: #ffe4e6;
    color: #e11d48;
}

.health-content {
    position: relative;
    z-index: 1;
    min-width: 0;
}

.health-content > span {
    color: #64748b;
    font-size: 10px;
    font-weight: 700;
}

.health-content h3 {
    margin: 6px 0;
    color: #111827;
    font-size: 28px;
    font-weight: 850;
}

.health-content small {
    color: #94a3b8;
    font-size: 9px;
}

.health-decoration {
    position: absolute;
    right: 24px;
    bottom: -19px;
    color: #e2e8f0;
    font-size: 95px;
    opacity: .45;
    pointer-events: none;
}

.health-view-btn {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 2;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 9px;
    background: #ffffff;
    color: #64748b;
    box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
}

.health-view-btn:hover {
    color: #4f46e5;
}


/* -----------------------------------------------------
   DASHBOARD FOOTER
----------------------------------------------------- */

.dashboard-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 20px 3px 5px;
    border-top: 1px solid #e9edf5;
    color: #94a3b8;
    font-size: 10px;
}

.dashboard-footer > div {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

.footer-brand-mark {
    width: 25px;
    height: 25px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 7px;
    background: #eef2ff;
    color: #4f46e5;
}

.dashboard-footer strong {
    color: #475569;
    font-size: 10px;
    letter-spacing: 1px;
}

.footer-divider {
    color: #cbd5e1;
}


/* -----------------------------------------------------
   RESPONSIVE
----------------------------------------------------- */

@media (max-width: 1199.98px) {

    .metric-value {
        font-size: 23px;
    }

    .dashboard-hero {
        padding: 30px;
    }

}

@media (max-width: 767.98px) {

    .erp-dashboard {
        padding-top: 16px !important;
    }

    .dashboard-hero {
        align-items: flex-start;
        flex-direction: column;
        gap: 22px;
        padding: 26px 22px;
        border-radius: 19px;
    }

    .dashboard-hero h1 {
        font-size: 30px;
        letter-spacing: -1px;
    }

    .dashboard-hero p {
        font-size: 12px;
    }

    .hero-actions {
        width: 100%;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .hero-report-btn,
    .hero-primary-btn {
        flex: 1 1 150px;
        font-size: 10px;
        padding: 12px;
    }

    .section-heading h4 {
        font-size: 16px;
    }

    .section-period {
        font-size: 9px;
        padding: 7px 9px;
    }

    .metric-card {
        padding: 19px;
    }

    .metric-top {
        margin-bottom: 17px;
    }

    .metric-value {
        font-size: 23px;
    }

    .panel-header {
        padding: 17px;
    }

    .panel-body {
        padding: 18px;
    }

    .panel-title-group {
        gap: 9px;
    }

    .panel-title-icon {
        width: 36px;
        height: 36px;
        font-size: 16px;
    }

    .panel-title-group h5 {
        font-size: 12px;
    }

    .panel-title-group p {
        font-size: 9px;
    }

    .sales-chart-container {
        height: 245px;
    }

    .chart-summary h3 {
        font-size: 21px;
    }

    .inventory-health-card {
        min-height: 125px;
        padding: 18px;
        gap: 13px;
    }

    .health-icon {
        width: 45px;
        height: 45px;
        font-size: 19px;
    }

    .health-content h3 {
        font-size: 24px;
    }

}

@media (max-width: 480px) {

    .dashboard-hero {
        padding: 23px 18px;
    }

    .dashboard-hero h1 {
        font-size: 27px;
    }

    .hero-meta {
        gap: 9px;
        font-size: 10px;
    }

    .hero-actions {
        flex-direction: column;
    }

    .section-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .section-period {
        align-self: flex-start;
    }

    .metric-value {
        font-size: 21px;
    }

    .metric-currency {
        font-size: 10px;
    }

    .panel-header {
        gap: 8px;
    }

    .panel-badge {
        font-size: 8px;
        padding: 6px 7px;
    }

    .panel-link {
        font-size: 10px;
    }

    .profit-breakdown-item {
        align-items: flex-start;
    }

    .profit-breakdown-item > strong {
        max-width: 55%;
    }

    .quick-actions-grid {
        gap: 8px;
    }

    .quick-action-card {
        padding: 12px 9px;
        gap: 8px;
    }

    .quick-action-icon {
        width: 32px;
        height: 32px;
        font-size: 15px;
    }

    .quick-action-label {
        font-size: 9px;
    }

    .dashboard-footer {
        align-items: flex-start;
        flex-direction: column;
    }

}


/* -----------------------------------------------------
   ACCESSIBILITY
----------------------------------------------------- */

@media (prefers-reduced-motion: reduce) {

    .erp-dashboard *,
    .erp-dashboard *::before,
    .erp-dashboard *::after {
        scroll-behavior: auto !important;
        transition-duration: .01ms !important;
        animation-duration: .01ms !important;
    }

}

</style>

@endsection
