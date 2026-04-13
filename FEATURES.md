# Feature Requests & Roadmap

> This document tracks planned improvements and new features for the Shakyy system.

---

## 1. Sales & Table Filtering Improvements ✅ IMPLEMENTED

- Enable the creation of a single sale transaction containing **multiple products with different prices** within the same invoice.

---

## 2. Dashboard Enhancements ✅ IMPLEMENTED

### 2.1 Date Range Filtering ✅

- Add a date range filter to the dashboard.
- Users should be able to select a custom period to view corresponding data and analytics.

### 2.2 Pending Payments Dashboard Card ✅

Introduce a new dashboard card displaying:

- **Total Unpaid Amount**
- **Total Partially Paid Amount**

**Purpose:**

- Improve visibility of expected cash flow.
- Assist in tracking overdue invoices and payment follow-ups.

**Revenue Calculation Rule:**

- Sales with **Pending** or **Partially Paid** status must **NOT** be included in the Total Revenue card.
- Revenue should only be counted when the payment status changes to **Paid**.
- Pending and partially paid amounts should appear only in the Pending Payments card.

---

## 3. Inventory Cost Tracking & Valuation

The system must support:

- Cost per item tracking
- Total stock value calculation
- **FIFO (First-In, First-Out)** valuation method
- Profit calculation based on:
  - Item cost
  - Selling price

---

## 4. Automated Business Reports

### 4.1 Required Reports

- Sales Summary
- Revenue vs. Cost
- Profit Summary
- Inventory Valuation

### 4.2 Report Features

Each report must include:

- Date range selection
- Filtering by product or category
- Export options:
  - Excel
  - PDF

---

## 5. Customer Tracking (Accounts Receivable) ✅ IMPLEMENTED

For every sale, store the following:

- Customer Name
- Invoice Number
- Total Amount
- Amount Paid
- Remaining Balance
- Payment Status
- Due Date
- Overdue Indicator

---

## 6. Supplier Tracking (Accounts Payable)

For every purchase, store the following:

- Supplier Name
- Invoice Number
- Total Amount
- Amount Paid
- Remaining Balance
- Payment Status
- Due Date

---

## 7. Employee Profile Photo Upload ✅ IMPLEMENTED

- Allow employees to upload and store profile photos.
- Uploaded photos must be displayed on employee profiles.

---
