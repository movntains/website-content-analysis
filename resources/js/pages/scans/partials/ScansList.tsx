import HeadingSmall from '@/components/heading-small';
import ListCard from '@/components/ListCard';
import ListCardItem from '@/components/ListCardItem';
import TextLink from '@/components/text-link';
import { CardTitle } from '@/components/ui/card';
import ScanStatus from '@/pages/scans/partials/ScanStatus';

import { formatDate } from '@/lib/utils';
import { show } from '@/routes/scans';
import type { ScanOverview } from '@/types/scan';

interface ScansListProps {
  scans: ScanOverview[];
}

export default function ScansList({ scans }: ScansListProps) {
  return (
    <div className="flex flex-col gap-4 lg:hidden">
      {scans.map((scan) => (
        <ListCard
          key={scan.uuid}
          header={
            <>
              <CardTitle>
                <HeadingSmall title="Scan for:" />
                <span className="wrap-anywhere">{scan.url}</span>
              </CardTitle>

              <TextLink
                href={show(scan.uuid)}
                className="flex flex-col gap-2"
              >
                <span>View Details</span>
                <span className="sr-only"> About Scan for {scan.url}</span>
              </TextLink>
            </>
          }
        >
          <ListCardItem>
            <dt className="font-medium">Domain:</dt>
            <dd>{scan.domainName}</dd>
          </ListCardItem>
          <ListCardItem>
            <dt className="font-medium">Scanned At:</dt>
            <dd>{formatDate(scan.createdAt)}</dd>
          </ListCardItem>
          <ListCardItem>
            <dt className="font-medium">Status:</dt>
            <dd>
              <ScanStatus status={scan.status} />
            </dd>
          </ListCardItem>
        </ListCard>
      ))}
    </div>
  );
}
