<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExpenseRequest;
use App\Http\Requests\Admin\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Services\ExpenseAnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function __construct(private readonly ExpenseAnalyticsService $analytics)
    {
    }

    public function index(Request $request): View
    {
        $year = max(2000, min(2100, (int) $request->integer('year', now()->year)));
        $cogsMonth = max(1, min(12, (int) $request->integer('cogs_month', now()->month)));
        $operatingMonth = max(1, min(12, (int) $request->integer('operating_month', now()->month)));

        $tab = (string) $request->query('tab', 'overview');
        if (! in_array($tab, ['overview', 'cogs', 'operating', 'add'], true)) {
            $tab = 'overview';
        }

        return view('admin.expenses.index', [
            'year' => $year,
            'tab' => $tab,
            'cogsMonth' => $cogsMonth,
            'operatingMonth' => $operatingMonth,
            'categories' => $this->groupedCategories(),
            'monthlyTotals' => $this->analytics->monthlyTotals($year),
            'yearSummary' => $this->analytics->yearSummary($year),
            'cogsFullYear' => $this->analytics->fullYearBreakdown($year, ExpenseCategory::TYPE_COGS),
            'operatingFullYear' => $this->analytics->fullYearBreakdown($year, ExpenseCategory::TYPE_OPERATING),
            'cogsMonthBreakdown' => $this->analytics->monthBreakdown($year, $cogsMonth, ExpenseCategory::TYPE_COGS),
            'operatingMonthBreakdown' => $this->analytics->monthBreakdown($year, $operatingMonth, ExpenseCategory::TYPE_OPERATING),
            'recentExpenses' => Expense::query()
                ->with('category')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit(10)
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.expenses.create', [
            'categories' => $this->groupedCategories(),
        ]);
    }

    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        $data = $this->prepareExpenseData($request->validated());
        Expense::create($data);

        $redirectParams = ['year' => $data['year']];

        if ($request->boolean('from_index')) {
            $redirectParams['tab'] = 'add';
        }

        return redirect()
            ->route('admin.expenses.index', $redirectParams)
            ->with('status', 'Expense recorded successfully.');
    }

    public function edit(Expense $expense): View
    {
        $expense->load('category');

        return view('admin.expenses.edit', [
            'expense' => $expense,
            'categories' => $this->groupedCategories(),
        ]);
    }

    public function update(UpdateExpenseRequest $request, Expense $expense): RedirectResponse
    {
        $data = $this->prepareExpenseData($request->validated());
        $expense->update($data);

        return redirect()
            ->route('admin.expenses.index', ['year' => $data['year']])
            ->with('status', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $year = $expense->year;
        $expense->delete();

        return redirect()
            ->route('admin.expenses.index', ['year' => $year, 'tab' => 'add'])
            ->with('status', 'Expense deleted successfully.');
    }

    /**
     * @return array<string, \Illuminate\Support\Collection<int, ExpenseCategory>>
     */
    private function groupedCategories(): array
    {
        $categories = ExpenseCategory::query()
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return [
            ExpenseCategory::TYPE_COGS => $categories->where('type', ExpenseCategory::TYPE_COGS)->values(),
            ExpenseCategory::TYPE_OPERATING => $categories->where('type', ExpenseCategory::TYPE_OPERATING)->values(),
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function prepareExpenseData(array $validated): array
    {
        $date = Carbon::createFromDate(
            (int) $validated['year'],
            (int) $validated['month'],
            (int) $validated['day'],
        );

        return [
            'expense_category_id' => (int) $validated['expense_category_id'],
            'name' => trim((string) $validated['name']),
            'amount' => round((float) $validated['amount'], 2),
            'currency' => strtoupper(trim((string) ($validated['currency'] ?? 'RWF'))) ?: 'RWF',
            'expense_date' => $date->toDateString(),
            'month' => (int) $date->month,
            'year' => (int) $date->year,
            'notes' => isset($validated['notes']) ? trim((string) $validated['notes']) : null,
        ];
    }
}
