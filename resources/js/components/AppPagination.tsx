import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationLink,
  PaginationNext,
  PaginationPrevious,
} from '@/components/ui/pagination';

import type { PaginationLink as PaginationLinkType } from '@/types/pagination';

interface AppPaginationProps {
  links: PaginationLinkType[];
  previousPageUrl: string | null;
  nextPageUrl: string | null;
}

export default function AppPagination({ links, previousPageUrl, nextPageUrl }: AppPaginationProps) {
  return (
    <Pagination>
      <PaginationContent>
        {previousPageUrl && (
          <PaginationItem>
            <PaginationPrevious href={previousPageUrl} />
          </PaginationItem>
        )}

        {links
          .filter((link) => !['&laquo; Previous', 'Next &raquo;'].includes(link.label))
          .map((link, index) => (
            <PaginationItem key={`pagination-link-${index}`}>
              {link.url === null && <span>{link.label}</span>}

              {link.url !== null && (
                <PaginationLink
                  href={link.url}
                  isActive={link.active}
                  prefetch
                >
                  {link.label}
                </PaginationLink>
              )}
            </PaginationItem>
          ))}

        {nextPageUrl && (
          <PaginationItem>
            <PaginationNext href={nextPageUrl} />
          </PaginationItem>
        )}
      </PaginationContent>
    </Pagination>
  );
}
