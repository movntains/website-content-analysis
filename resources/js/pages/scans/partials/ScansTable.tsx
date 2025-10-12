import TextLink from '@/components/text-link';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import ScanStatus from '@/pages/scans/partials/ScanStatus';

import { formatDate } from '@/lib/utils';
import { show } from '@/routes/scans';
import type { ScanOverview } from '@/types/scan';

interface ScansTableProps {
  scans: ScanOverview[];
}

export default function ScansTable({ scans }: ScansTableProps) {
  return (
    <Table className="max-lg:hidden">
      <TableHeader>
        <TableRow>
          <TableHead>Domain</TableHead>
          <TableHead>URL</TableHead>
          <TableHead>Scanned At</TableHead>
          <TableHead>Status</TableHead>
          <TableHead>
            <span className="sr-only">Actions</span>
          </TableHead>
        </TableRow>
      </TableHeader>

      <TableBody>
        {scans.map((scan) => (
          <TableRow key={scan.uuid}>
            <TableCell>{scan.domainName}</TableCell>
            <TableCell>{scan.url}</TableCell>
            <TableCell>{formatDate(scan.createdAt)}</TableCell>
            <TableCell>
              <ScanStatus
                status={scan.status}
                classes="w-full"
              />
            </TableCell>
            <TableCell className="text-right">
              <TextLink
                href={show(scan.uuid)}
                prefetch
              >
                <span>View Details</span>
                <span className="sr-only"> About Scan for {scan.url}</span>
              </TextLink>
            </TableCell>
          </TableRow>
        ))}
      </TableBody>
    </Table>
  );
}
