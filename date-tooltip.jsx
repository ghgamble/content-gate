const DateToolTip = () => {
    return (
      <InfoTooltip
        label={<ToolTipText />}
        infoTooltipChildrenClassNames={['md:block', 'hidden', 'ml-1.5']}
      />
    );
  };
  
  const Dates = () => (
    <div>
      {
        courseType === 'SAFe Advanced Scrum Master' ? (
          <>
            {`${getFromDate()}, ${getToDate()}`} <DateToolTip />
          </>
        ) : (
          `${getFromDate()} - ${getToDate()}`
        )
      }
    </div>
  );
  