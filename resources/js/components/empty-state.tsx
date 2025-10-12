import { PropsWithChildren, ReactNode } from 'react';

import { Empty, EmptyContent, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';

interface EmptyStateProps {
  icon: ReactNode;
  title?: string;
  description?: string;
}

export default function EmptyState({
  children,
  icon,
  description = '',
  title = '',
}: PropsWithChildren<EmptyStateProps>) {
  return (
    <Empty className="border border-solid">
      <EmptyHeader>
        <EmptyMedia variant="icon">{icon}</EmptyMedia>

        {title && <EmptyTitle>{title}</EmptyTitle>}

        {description && <EmptyDescription>{description}</EmptyDescription>}
      </EmptyHeader>

      <EmptyContent>{children}</EmptyContent>
    </Empty>
  );
}
