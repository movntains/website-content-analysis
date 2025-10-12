interface HeadingProps {
  title: string;
  description?: string;
  level?: 'h1' | 'h2';
}

export default function Heading({ title, description, level = 'h2' }: HeadingProps) {
  return (
    <div className="mb-8 space-y-0.5">
      {level === 'h1' ? (
        <h1 className="text-2xl font-bold tracking-tight">{title}</h1>
      ) : (
        <h2 className="text-xl font-semibold tracking-tight">{title}</h2>
      )}

      {description && <p className="text-sm text-muted-foreground">{description}</p>}
    </div>
  );
}
