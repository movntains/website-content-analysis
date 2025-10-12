import { Head } from '@inertiajs/react';

import { AppContent } from '@/components/app-content';
import Heading from '@/components/heading';
import AppLayout from '@/layouts/app-layout';

import CreateScanForm from '@/pages/scans/partials/CreateScanForm';
import { create, index } from '@/routes/scans';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Scans',
    href: index().url,
  },
  {
    title: 'Create New URL Scan',
    href: create().url,
  },
];

export default function ScansCreate() {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Create a New URL Scan" />

      <AppContent>
        <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <Heading
            title="Create a New URL Scan"
            level="h1"
            description="Enter a URL to scan and analyze its content for clarity, consistency, SEO-friendliness, and tone."
          />

          <CreateScanForm />
        </div>
      </AppContent>
    </AppLayout>
  );
}
