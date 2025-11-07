.PHONY: test_with_coverage

test_with_coverage: xdebug_on pest clean

xdebug_on:
	@echo "Enabling Xdebug..."
	ddev xdebug on

pest:
	@echo "Running tests with coverage..."
	XDEBUG_TRIGGER=yes ddev exec composer test:with-coverage

clean:
	@echo "Disabling Xdebug..."
	ddev xdebug off
