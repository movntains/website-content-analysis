import { Head, Link } from '@inertiajs/react';
import { Radar } from 'lucide-react';

import { AppContent } from '@/components/app-content';
import EmptyState from '@/components/empty-state';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import ScansList from '@/pages/scans/partials/ScansList';
import ScansTable from '@/pages/scans/partials/ScansTable';

import { create } from '@/routes/scans';
import type { BreadcrumbItem } from '@/types';
import type { Paginator } from '@/types/pagination';
import type { ScanOverview } from '@/types/scan';

interface ScansIndexProps {
  breadcrumbs: BreadcrumbItem[];
  scans: Paginator<ScanOverview>;
}

export default function ScansIndex({ breadcrumbs, scans }: ScansIndexProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Your URL Scans" />

      <AppContent>
        <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <div className="mb-6 flex flex-col items-start justify-between lg:flex-row lg:items-center">
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

          {scans.data.length === 0 && (
            <EmptyState
              icon={<Radar />}
              title="No Scans Yet"
              description="You haven't scanned any URLs yet."
            >
              <Button
                asChild
                variant="secondary"
              >
                <Link href={create()}>Scan Your First URL</Link>
              </Button>
            </EmptyState>
          )}

          {scans.data.length > 0 && (
            <Card>
              <CardHeader>
                <CardTitle>
                  <Heading title="Scans" />
                </CardTitle>
              </CardHeader>

              <CardContent>
                <ScansTable scans={scans.data} />

                <ScansList scans={scans.data} />
              </CardContent>
            </Card>
          )}
        </div>
      </AppContent>
    </AppLayout>
  );
}
