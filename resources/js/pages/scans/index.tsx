import { AppContent } from '@/components/app-content';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { create, index } from '@/routes/scans';
import type { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface ScansIndexProps {
  scans: any[];
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Scans',
    href: index().url,
  },
];

export default function ScansIndex({ scans }: ScansIndexProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Your URL Scans" />

      <AppContent>
        <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <div className="mb-6 flex items-center justify-between">
            <Heading
              title="Your URL Scans"
              level="h1"
              description="Manage and monitor your URL scans."
            />

            <Button
              asChild
              variant="default"
            >
              <Link href={create()}>Create a New Scan</Link>
            </Button>
          </div>

          {scans.length === 0 && (
            <div className="flex flex-col gap-4">
              <p className="text-gray-500 dark:text-gray-400">You haven't scanned any URLs yet.</p>

              <div>
                <Button
                  asChild
                  variant="outline"
                >
                  <Link href={create()}>Scan Your First URL</Link>
                </Button>
              </div>
            </div>
          )}
        </div>
      </AppContent>
    </AppLayout>
  );
}
