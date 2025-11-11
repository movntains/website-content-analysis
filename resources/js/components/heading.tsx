import { cn } from '@/lib/utils';

interface HeadingProps {
  title: string;
  description?: string;
  level?: 'h1' | 'h2';
  containerClasses?: string;
}

export default function Heading({ title, description, level = 'h2', containerClasses = 'mb-4' }: HeadingProps) {
  return (
    <div className={cn('space-y-0.5', containerClasses)}>
      {level === 'h1' ? (
        <h1 className="text-2xl font-bold tracking-tight">{title}</h1>
      ) : (
        <h2 className="text-xl font-semibold tracking-tight">{title}</h2>
      )}

      {description && <p className="text-sm text-muted-foreground">{description}</p>}
    </div>
  );
}
